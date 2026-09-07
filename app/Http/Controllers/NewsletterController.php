<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\BillingDetail;
use Hash;
use App\Order;
use App\Feature;
use App\Page;
use App\Contact;
use Carbon\Carbon;
use App\NewsletterDraft;
use App\LinkedList;
use App\MaxxFunctions;
use App\NewsletterJob;
use App\NewsletterCampaign;
use Illuminate\Support\Facades\Storage;
use App\Jobs\NewsletterEmailJob;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class NewsletterController extends Controller
{
    public function bulkemail(){ 
        $html  = file_get_contents('https://maxxresponse.com/draft/preview/47');
        $emails = array('yogesh@maxxmann.in');
        NewsletterEmailJob::dispatch($emails,$html);
    }

    //
    public function drafts(){
        Session::put('menuactive','drafts');
        $drafts = NewsletterDraft::with(['linkedlist','page'])->where('user_id',Auth::user()->id)->orderby('updated_at','DESC')->where('is_delete','no')->get();
        $drafts = json_decode(json_encode($drafts),true);
        $title = "Drafts";
      
        return view('front.newsletters.drafts')->with(compact('title','drafts'));
    }

    public function draftpreview($id){
        $draft = NewsletterDraft::where(['id'=>$id])->where('is_delete','no')->first();
        if($draft && !empty($draft->newsletter_file)){
            $userid = $draft->user_id;
            $filename = $draft->newsletter_file;
            $path = storage_path('app/templates/'.$userid.'/newsletter'.'/'. $filename);
            if(File::exists($path)){
                $html = File::get($path);
                return view('front.newsletters.draft-preview')->with(compact('html'));
            }else{
               abort(404);
            }
        }else{
            abort(404);
        }
    }

    public function deletedraft($id){
        $draft = NewsletterDraft::where(['user_id'=>Auth::user()->id,'id'=>$id])->where('is_delete','no')->first();
        if($draft){
            NewsletterDraft::where('id',$id)->update(['is_delete'=>'yes','deleted_at'=>date('Y-m-d h:i:s')]);
            return redirect()->back()->with('flash_message_success','Draft has been deleted successfully');
        }else{
            abort(404);
        }
    }
    
    public function createNewsletter(Request $request,$slug){
    	$availableSlugs = array('choose-html-or-plain','basic-settings');
        	if(in_array($slug, $availableSlugs)){
    	     	if($slug=="choose-html-or-plain"){
    		    	$title = "Create Newsletter";
    			return view('front.newsletters.choose-html-or-plain')->with(compact('title'));
    		}elseif($slug=="basic-settings"){
                $data = $request->all();
                $draftdetails = array();
                if(isset($data['ref'])){
                    $uniqid = $data['ref'];
                    $response = MaxxFunctions::checkValidUniqId('newsletter',$uniqid);
                    if($response=="false"){
                        return redirect::to('/');
                    }else{
                        $draftdetails = NewsletterDraft::where('unique_id',$data['ref'])->first();
                        $draftdetails = json_decode(json_encode($draftdetails),true);
                    }
                }
    			if($request->isMethod('get')){
    				if(!empty($data)){
    					$availableTypes = array('editor','plain-html');
	    				if(in_array($data['type'],$availableTypes)){
	    					$type = $data['type'];
	    					$title ="Basic Settings";
    						return view('front.newsletters.basic-settings')->with(compact('title','type','draftdetails'));
	    				}else{
	    					abort(404);
	    				}
    				}
    			}elseif($request->isMethod('post')){
    				$rules = [
                        'from_email' => 'bail|required|email|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i|string|max:255',
                        'message_name' => 'bail|required|string|max:255',
                        'list_id' => 'bail|required',
                        'subject' => 'bail|required|string|max:255',
                        'type' => 'bail|required'
                    ];
                    $customMessages = [
                    ];
                    $this->validate($request, $rules, $customMessages);
                    $listreponse = MaxxFunctions::validList($data['list_id']);
                    if($listreponse === true){
                        if($draftdetails){
                            $draft = NewsletterDraft::find($draftdetails['id']);
                        }else{
                            $draft = new NewsletterDraft;
                        }
                        $draft->draft_type =  $data['type'];
                        $draft->linked_list_id =  $data['list_id'];
                        $uniqid =$this->generateUniqid();
                        $draft->unique_id = $uniqid; 
                        $draft->message_name = $data['message_name'];
                        $draft->subject = $data['subject'];
                        $draft->from_email = $data['from_email'];
                        $draft->from_name = Auth::user()->name;
                        $draft->source_address = Auth::user()->name." <".$data['from_email'].">";
                        $draft->user_id = Auth::user()->id;
                        $draft->save(); 
                        if($draftdetails && $draftdetails['newsletter_file'] !=""){
                            if($data['type'] =="editor"){
                                return redirect::to('html/editor?type=newsletter&ref='.$uniqid);
                            }elseif ($data['type'] =="plain-html") {
                                return redirect::to('create-plain-html?ref='.$uniqid);
                            }
                        }else{
                            if($data['type'] =="editor"){
                                return redirect::to('newsletter-choose-template?ref='.$uniqid);
                            }elseif ($data['type'] =="plain-html") {
                                return redirect::to('create-plain-html?ref='.$uniqid);
                            }else{
                                return redirect::back();
                            }
                        }
                    }else{
                        return redirect::back();
                    }
    			}
    		}
    	}else{
    		abort(404);
    	}
    }
    public function newsletterChooseTemplate(Request $request){
        if(isset($_GET['ref']) && !empty($_GET['ref'])){
            $uniqid = $_GET['ref'];
            $response = MaxxFunctions::checkValidUniqId('newsletter',$uniqid);
        }else{
            return redirect::to('/');
        }
        if($response =='true'){
			if($request->isMethod('get')){
            	$featureids = Feature::featureids('newsletter');
                $templates = Page::where('status',1)->wherein('feature_id',$featureids);
                $data =$request->all();
                if(!empty($data)){
                    if(isset($data['q'])){
                        $templates = $templates->where('name','like','%'.$data['q'].'%');
                    }
                    if(isset($data['template']) && !empty($data['template'])){
                        if($data['template'] !="all-templates"){
                            $id = DB::table('features')->where('slug',$data['template'])->select('id')->first();
                            if($id){
                                $templates = $templates->where('feature_id',$id->id);
                            }
                        }
                    }
                    if(isset($data['sort'])){
                        if($data['sort'] =="date"){
                            $templates = $templates->orderby('created_at','DESC');
                        }elseif($data['sort'] =="asc"){
                            $templates = $templates->orderby('name','asc');
                        }elseif($data['sort'] =="desc"){
                            $templates = $templates->orderby('name','desc');
                        }
                    }else{
                        $templates = $templates->orderby('id','desc');
                    }
                }
            }
			$title="Choose Template";
            $slug="newsletter";
	        $templates = $templates->paginate(50);
            if($request->ajax()){
                return response()->json([
                    'view' => (String)View::make('layouts.frontLayout.newsletter-layout')->with(compact('templates','uniqid'))
                ]);
            }else{
                return view('front.newsletters.choose-template')->with(compact('title','slug','templates','uniqid')); 
            }
		}else{
           	return redirect::to('/');
        }
    }
    public function createPlainHtml(Request $request){
        if($request->isMethod('get')){
            $title = "Create Plain HTML";
            $data = $request->all();
            $rules = [
                'ref' => 'bail|required',
            ];
            $customMessages = [
            ];
            $validator = Validator::make($data,$rules);
            if($validator->fails()) {
                return redirect::back();
            }
            $uniqid = $data['ref'];
            $response = MaxxFunctions::checkValidUniqId('newsletter',$uniqid);
            if($response=="true"){
                $details = NewsletterDraft::where(['unique_id'=>$uniqid])->first();
                $html="";
                if(!empty($details->newsletter_file)){
                    $userid = Auth::user()->id;
                    $filename = $details->newsletter_file;
                    $path = storage_path('app/templates/'.$userid.'/newsletter'.'/'. $filename);
                    if(File::exists($path)){
                        $html = File::get($path);
                    }
                }

                    $roles = DB::connection('mysql2')->table('roles')->where('is_published', '=', '1')
                        ->orderBy('updated_at', 'desc')->get();;

                return view('front.newsletters.create-plain-html')->with(compact('title','uniqid','html','roles'));
            }else{
                return redirect::to('/');
            }
        }else{
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $rules = [
                'ref' => 'bail|required',
                'html' => 'bail|required',
            ];
            $customMessages = [
            ];
            $validator = Validator::make($data,$rules);
            if($validator->fails()) {
                return redirect::back();
            }
            $uniqid = $data['ref'];
            $response = MaxxFunctions::checkValidUniqId('newsletter',$uniqid);
            if($response=="true"){
                $html = substr($_POST['html'], 0, 1024 * 1024 * 2);
                $folder = Auth::user()->id;
                $details = NewsletterDraft::where(['unique_id'=>$uniqid])->first();
                $details = json_decode(json_encode($details),true);
                if(!empty($details['newsletter_file'])){
                    $filename = $details['newsletter_file'];
                }else{
                    $filename = "newsletter-".$uniqid.$details['id'].Str::random(2).".html";
                }
                NewsletterDraft::where('id',$details['id'])->update(['newsletter_file'=>$filename]);
                $filePath = "templates/".$folder."/newsletter"."/".$filename;
                Storage::disk('local')->put($filePath, $html);
                return redirect::to('/newsletter-summary?ref='.$uniqid);
            }else{
                 return redirect::to('/');
            }
        }
    }

    public function getcampaignId(request $request, $id){

        //dd($id);
        
        $service = DB::connection('mysql2')->table('roles')->where('id', $id)->first();  



        $data['name'] =$service->name;
        $data['email_id'] = 'test@test.com';
        $data['description'] = $service->description;
        $data['work_experience_year'] = $service->work_experience_year;        
      
        $content = view('emails.invite_talent_preview', [ 'data' => $data ])->render();
      //  return $content;
        return response()->json([  
                        "success" => "success",
                        "msg" =>"success",
                        'data'=>$content,
                ]);
    }


    public function newsletterSummary(Request $request){
        if($request->isMethod('get')){
            $data = $request->all();
            $rules = [
                'ref' => 'bail|required',
            ];
            $customMessages = [
            ];
            $validator = Validator::make($data,$rules);
            if($validator->fails()) {
                return redirect::back();
            }
            $uniqid = $data['ref'];
            $response = MaxxFunctions::checkValidUniqId('newsletter',$uniqid);
            //echo "<pre>"; print_r($response); die;
            if($response=="true"){
                $draftdetails = NewsletterDraft::with('template')->where('unique_id',$data['ref'])->first();
                $draftdetails = json_decode(json_encode($draftdetails),true);
                if(!empty($draftdetails['newsletter_file']) ){
                    $recipients = Contact::where('linked_list_id',$draftdetails['linked_list_id'])->count();
                    $listdetails = LinkedList::where('id',$draftdetails['linked_list_id'])->first();
                    $title = "Newsletter Summary";
                    return view('front.newsletters.summary')->with(compact('title','draftdetails','recipients','listdetails','uniqid'));
                }else{
                    return redirect::to('html/editor?type=newsletter&ref='.$uniqid);
                }
            }else{
                return redirect::to('/');
            }
        }
    }

    public function generateUniqid(){
    	$uniqid = uniqid();
    	$checkrefidexits = NewsletterDraft::where('unique_id',$uniqid)->count();
    	if($checkrefidexits == 0){
    		return $uniqid;
    	}else{
    		$uniqid = $uniqid.Str::random(3);
    		return $uniqid;
    	}	
    }

    public function newsletterCampaign(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'ref' => 'bail|required',
            ];
            $customMessages = [
            ];
            $validator = Validator::make($data,$rules);
            if($validator->fails()) {
                return redirect::back();
            }
            $uniqid = $data['ref'];
            $response = MaxxFunctions::checkValidUniqId('newsletter',$uniqid);
            //echo "<pre>"; print_r($response); die;
            if($response=="true"){
                $draftdetails = NewsletterDraft::select('id','user_id','linked_list_id','source_address')->where('unique_id',$data['ref'])->first();
                $draftdetails = json_decode(json_encode($draftdetails),true);
                $newsurl = url('/draft/preview/'.$draftdetails['id']);
                //craete Newsletter campaign
                $campaign = new NewsletterCampaign;
                $campaign->newsletter_draft_id = $draftdetails['id'];
                $campaign->linked_list_id = $draftdetails['linked_list_id'];
                $campaign->user_id =Auth::user()->id;
                $campaign->newsletter_url = $newsurl;
                $campaign->source = $draftdetails['source_address'];
                $campaign->save();
                $campaignid = DB::getPdo()->lastInsertId();
                $totalemails = Contact::where('email','!=','')->where('linked_list_id',$draftdetails['linked_list_id'])->count();
                $take = 50; 
                $startvalue = range(1,$totalemails);
                $ranges = array_chunk($startvalue,$take);
                foreach ($ranges as $key => $range) {
                    $all_values = array_values($range);
                    $skip = array_shift($all_values) - 1;
                    $job = new NewsletterJob;
                    $job->job_date = date('Y-m-d');
                    $job->skip = $skip;
                    $job->take = $take;
                    $job->newsletter_campaign_id = $campaignid;
                    $job->is_run  = 'no';
                    $job->created_by =Auth::user()->id;
                    $job->save();
                }
                return redirect::to('/drafts')->with('flash_message_success','Done!... Your Newsletter campaign has been started successfully.');
            }else{
                return redirect::to('/');
            }
        }
    }

    public function runNewsletterCampaign(){
        $getLatestCampaign = NewsletterJob::with(['campaign','user'])->where('is_run','no')->first();
        //echo '<pre>'; print_r(json_decode(json_encode($getLatestCampaign),true)); die;
        if($getLatestCampaign){
            NewsletterJob::where('id',$getLatestCampaign->id)->update(['is_run'=>'yes']);
            if($this->smsmode =="live"){
                $html  = file_get_contents($getLatestCampaign->campaign->newsletter_url);
            }else{
                $html='';
            }
            $emails = Contact::where(['linked_list_id'=> $getLatestCampaign->campaign->linked_list_id])->skip($getLatestCampaign->skip)->take($getLatestCampaign->take)->select('email')->get();
            $emails = Arr::flatten(json_decode(json_encode($emails),true));
            $emaildata = array('emails'=> $emails,'mailbody'=>$html,'from_name'=>$getLatestCampaign->campaign->draft->from_name,'from_email'=>$getLatestCampaign->campaign->draft->from_email,'subject'=>$getLatestCampaign->campaign->draft->subject,'heading'=>$getLatestCampaign->user->name);
            NewsletterEmailJob::dispatch($emaildata);
            echo "cron job run successfully";
        }else{
            echo 'nothing to run';
        }
    }

    public function newsletterCampaignList() {

        //get all campaign information
        $campaigns = DB::connection('mysql2')->table('campaigns')->get();
        return view('front.newsletters.newsletter-campaign-list')->with(compact('campaigns'));

    }

    public function newsletterReport() {
        return view('front.newsletters.newsletter-report');
    }

     public function newsletterCampaigns() {
        return view('front.newsletters.email-campaigns');   
    }

    public function newsletterCampaignDetails() {
        return view('front.newsletters.email-campaign-details');   
    }

}
