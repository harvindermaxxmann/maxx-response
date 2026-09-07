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
use Illuminate\Support\Facades\Auth;
use App\BillingDetail;
use Hash;
use App\Order;
use App\Feature;
use App\Page;
use App\LandingPage;
use App\Contact;
use Carbon\Carbon;
use App\MaxxFunctions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class LandingPageController extends Controller
{
    //
    public function landingpages(){
        Session::put('menuactive','landingpage');
        $lps = LandingPage::with(['page'])->where('user_id',Auth::user()->id)->orderby('updated_at','DESC')->where('is_delete','no')->get();
        $lps = json_decode(json_encode($lps),true);
        $title = "Landing Pages";
        return view('front.landing-pages.lps')->with(compact('title','lps'));
    }

    public function landingpreview($id){
        $lp = LandingPage::where('id',$id)->where('is_delete','no')->first();
        if($lp && !empty($lp->landing_file)){
            $userid = $lp->user_id;
            $filename = $lp->landing_file;
            $path = storage_path('app/templates/'.$userid.'/landing-pages'.'/'. $filename);
            if(File::exists($path)){
                $html = File::get($path);
                return view('front.landing-pages.lp-preview')->with(compact('html'));
            }else{
               abort(404);
            }
        }else{
            abort(404);
        }
    }

    public function deletelanding($id){
        $draft = LandingPage::where(['user_id'=>Auth::user()->id,'id'=>$id])->where('is_delete','no')->first();
        if($draft){
            LandingPage::where('id',$id)->update(['is_delete'=>'yes','deleted_at'=>date('Y-m-d h:i:s')]);
            return redirect()->back()->with('flash_message_success','Landing Page has been deleted successfully');
        }else{
            abort(404);
        }
    }

	public function landingchoosetemplate(Request $request){
		$title="Landing Page - Choose Template";
		$slug="landing-page";
		$featureids = Feature::featureids($slug);
        $templates = Page::with('template')->where('status',1)->wherein('feature_id',$featureids);
        if($request->isMethod('get')){
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
        $templates = $templates->paginate(50);
        if($request->ajax()){
            return response()->json([
                'view' => (String)View::make('layouts.frontLayout.landing-layout')->with(compact('templates'))
            ]);
        }else{
			return view('front.landing-pages.choose-template')->with(compact('title','slug','templates'));
        }
	}

	public function processLandingpage(Request $request){
		if($request->isMethod('post')){
			$data = $request->all();
			$rules = [
                'template_id' => 'bail|required',
                'page_id' => 'bail|required',
                'name' => 'bail|required',
            ];
            $customMessages = [];
            $validator = Validator::make($data,$rules);
            if($validator->fails()) {
                return redirect::back()->with('flash_message_error','Something Went wrong');
            }
            //Check Page exists or not
            $details = Page::where('id',$data['page_id'])->where('template_id',$data['template_id'])->count();
            if($details ==0){
            	return redirect::back()->with('flash_message_error','Something went wrong. Please try again after some time');
            }else{
            	//Create Landing Page and Redirect to editor
            	$uniqid =$this->generateUniqid();
            	$landing = new LandingPage;
            	$landing->user_id = Auth::user()->id;
            	$landing->unique_id = $uniqid;
            	$landing->page_id = $data['page_id'];
            	$landing->template_id = $data['template_id'];
            	$landing->name = $data['name'];
            	$landing->save();
            	return redirect::to('html/editor?type=landing-page&a=lp&ref='.$uniqid);
            }
		}
	}

    public function lpSettings(Request $request){
        $data = $request->all();
        $rules = [
            'ref' => 'bail|required',
        ];
        $validator = Validator::make($data,$rules);
        if($validator->fails()) {
            return redirect::to('/');
        }
        $uniqid = $data['ref'];
        $response = MaxxFunctions::checkValidUniqId('landing-page',$uniqid);
        if($response =='true'){
            $landingdetails = LandingPage::where('unique_id',$data['ref'])->first();
            if($landingdetails){
                if($request->isMethod('post')){
                    $data = $request->all();
                    //Check if subdomain already registered
                    $updateLanding = LandingPage::find($landingdetails->id);
                    $updateLanding->page_title = $data['page_title'];
                    $updateLanding->page_description = $data['page_description'];
                    if(empty($landingdetails->max_subdomain)){
                        $checksubdomain = LandingPage::where('subdomain',$data['subdomain'])->count();
                        if($checksubdomain >0){
                            return redirect()->back()->with('flash_message_error','This subdomain('.$data['subdomain'].') has already been taken. Please choose another one.');
                        }
                        $updateLanding->max_subdomain = "http://".$data['subdomain'].".".$data['domain'];
                        $updateLanding->subdomain = $data['subdomain'];
                    }else{
                        $data['subdomain'] = $updateLanding->subdomain;
                    }
                    if(isset($data['user_domain']) && empty($landingdetails->user_domain)){
                        $updateLanding->user_domain = $data['user_domain'];
                    }
                    $updateLanding->save();
                    if(empty($landingdetails->max_subdomain)){
                        //Create Subdomain
                        LandingPage::createSudomain($data['subdomain']);
                    }
                    //Transfer Files to subdomain
                    $transferResp= LandingPage::transferFiles($data['subdomain'],$landingdetails->id);
                    if($transferResp){
                        return redirect('/dashboard')->with('flash_message_success','Landing Page updated successfully');
                    }else{
                        return redirect('/dashboard')->with('flash_message_error','Something went wrong! While uploading files at subdomain');
                    }
                }
            }else{
                abort(404);
            }
        }else{
            return redirect::to('/');
        }
        $title ="Landing Page Settings";
        return view('front.landing-pages.lp-settings')->with(compact('title','uniqid','landingdetails'));
    }


	public function generateUniqid(){
    	$uniqid = uniqid();
    	$checkrefidexits = LandingPage::where('unique_id',$uniqid)->count();
    	if($checkrefidexits == 0){
    		return $uniqid;
    	}else{
    		$uniqid = $uniqid.Str::random(3);
    		return $uniqid;
    	}	
    }
}
