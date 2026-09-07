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
use App\Contact;
use Carbon\Carbon;
use App\NewsletterDraft;
use App\MaxxFunctions;
use App\Template;
use App\LandingPage;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EditorController extends Controller
{
    //
    public function viewtemplate($folder,$file){
    	$title = "View Template";
    	return view("templates.$folder.$file")->with(compact('title'));
    }

    public function processTemplate(Request $request){
    	if($request->isMethod('get')){
    		$data = $request->all();
    		$rules = [
	    		'type' =>'bail|required|string|max:255',
	            'ref' => 'bail|required|string|max:255',
	            'template' =>'bail|required|string|max:255',
	        ];
	        $customMessages = [
	        ];
	        $validator = Validator::make($data,$rules);
	        if($validator->fails()) {
	            return redirect::back();
	        }
	        $uniqid = $data['ref'];
	        $response = MaxxFunctions::checkValidUniqId($data['type'],$uniqid);
		    if($response =='true'){
		        if($data['type'] =="newsletter"){
		        	$checktemplate = Page::where('id',$data['template'])->first();
		        	//Save Template in Draft;
		        	$checkdraft = NewsletterDraft::where('user_id',Auth::user()->id)->where('unique_id',$uniqid)->first();
		        	if($checktemplate && $checkdraft){
		        		$draft  = NewsletterDraft::find($checkdraft->id);
		        		$draft->page_id = $checktemplate->id;
		        		$draft->template_id = $checktemplate->template_id;
		        		$draft->save();
		        		return redirect::to('html/editor?type=newsletter&ref='.$uniqid);
		        	}else{
		        		return redirect::to('/');
		        	}
		        }else{
		        	return redirect::to('/');
		        }
		    }else{
		    	return redirect::to('/');
		    }
    	}
    }

    public function uploadeditorImage(Request $request){
    	if($request->hasFile('file')){
            if ($request->file('file')->isValid()) {
                $file = $request->file('file');
                $img = Image::make($file);
                $destination = public_path('/images/TempImages/');
                $ext = $file->getClientOriginalExtension();
                $mainFilename = "temp-".time().Str::random(5).".".$ext;
                $img->save($destination.$mainFilename);
            }
            echo url('/images/TempImages/'.$mainFilename);
        }
    }

    public function Editor(Request $request){
    	if($request->isMethod('get')){
    		$data =$request->all();
    		$rules = [
                'ref' => 'bail|required',
                'type' => 'bail|required|string',
            ];
            $customMessages = [
            ];
            $validator = Validator::make($data,$rules);
            if($validator->fails()) {
                return redirect::back();
            }
            $availableTypes = array('newsletter','landing-page');
            if(in_array($data['type'], $availableTypes)){
            	$uniqid = $data['ref'];
	    		$response = MaxxFunctions::checkValidUniqId($data['type'],$uniqid);
			    if($response =='true'){
			    	if($data['type'] =="newsletter"){
			    		$checkdraft = NewsletterDraft::where('user_id',Auth::user()->id)->where('unique_id',$uniqid)->where('is_delete','no')->first();
				    	if(!empty($checkdraft->template_id)){
							$templateDetails = Template::where('id',$checkdraft->template_id)->first();
					    	if($templateDetails){
					    		if($checkdraft->save_template == $checkdraft->template_id ){
					    			$url = url('user-newsletter-template/'.Auth::user()->id."/".$checkdraft->newsletter_file);
					    		}else{
					    			if(!empty($checkdraft->newsletter_file)){
					    				NewsletterDraft::where('id',$checkdraft->id)->update(['newsletter_file'=>'','save_template'=>0]);
					    				$folder = Auth::user()->id;
					    				$filePath = "templates/".$folder."/newsletter"."/".$checkdraft->newsletter_file;
					    				unlink(storage_path('app/'.$filePath));
					    			}
					    			$url = url("view-template/".$templateDetails->folder.'/'.$templateDetails->filename);
					    		}
					    		$pages = array('name'=>$templateDetails->folder,'title'=>$templateDetails->name,'url'=>$url);
					    		$pages = json_encode($pages);
					    		$loadpage = $templateDetails->folder;
					    		return view('front.editor')->with(compact('pages','loadpage','templateDetails'));
					    	}else{
					    		return redirect::to('/');
					    	}
				    	}else{
				    		return redirect::to('/');
				    	}
			    	}elseif($data['type'] =="landing-page"){
			    		$actions = array('lp','tp');
			    		if(isset($_GET['a']) && in_array($_GET['a'],$actions)){
			    			$action = $_GET['a'];
			    			$checklanding = LandingPage::where('user_id',Auth::user()->id)->where('unique_id',$uniqid)->where('is_delete','no')->first();
				    		$templateDetails = Template::where('id',$checklanding->template_id)->first();
					    	if($templateDetails){
					    		if($action =="lp"){
				    				if(!empty($checklanding->landing_file)){
					    				$url = url('user-landing-page/'.Auth::user()->id."/".$checklanding->landing_file);
						    		}else{
						    			$url = url("view-template/".$templateDetails->folder.'/'.$templateDetails->filename);
						    		}
				    			}else{
				    				if($templateDetails->is_thankyou =="yes"){
				    					if(!empty($checklanding->thankyou_file)){
						    				$url = url('user-landing-page/'.Auth::user()->id."/".$checklanding->thankyou_file);
							    		}else{
							    			if(!empty($checklanding->landing_file)){
							    				$url = url("view-template/".$templateDetails->folder.'/'.$templateDetails->thankyou_filename);
							    			}else{
							    				return redirect::to('/html/editor?type=landing-page&a=lp&ref='.$uniqid);
							    			}
							    		}
				    				}else{
				    					return redirect::to('/html/editor?type=landing-page&a=lp&ref='.$uniqid);
				    				}
				    			}
					    		$pages = array('name'=>$templateDetails->folder,'title'=>$templateDetails->name,'url'=>$url);
					    		$pages = json_encode($pages);
					    		$loadpage = $templateDetails->folder;
					    		return view('front.editor')->with(compact('pages','loadpage','templateDetails'));
					    	}else{
					    		return redirect::to('/');
					    	}
			    		}else{
			    			return redirect::to('/');
			    		}
			    	}
			    }else{
			    	return redirect::to('/');
			    }
            }else{
            	return redirect::to('/');
            }
    	}
    }

    public function saveTemplate(Request $request){
    	if($request->ajax()){
    		$data = $request->all();
    		//echo "<pre>"; print_r($data);
    		$rules = [
                'ref' => 'bail|required',
                'type' => 'bail|required',
                'fileName' => 'bail|required',
            ];
            $customMessages = [
            ];
            $validator = Validator::make($data,$rules);
            if($validator->fails()) {
                return response()->json(['status'=>'failed']);
            }
            $availableTypes = array('newsletter','landing-page');
            if(in_array($data['type'], $availableTypes)){
            	$uniqid = $data['ref'];
	    		$response = MaxxFunctions::checkValidUniqId($data['type'],$uniqid);
			    if($response =='true'){
			    	if($data['type'] =="newsletter"){
			    		$checkdraft = NewsletterDraft::join('templates','templates.id','=','newsletter_drafts.template_id')->select('newsletter_drafts.*','templates.folder')->where('user_id',Auth::user()->id)->where('unique_id',$uniqid)->first();
				    	$folder = Auth::user()->id;
				    	$filename =  $checkdraft->folder.$data['ref'].".html";
				    	$html = "";
						if (isset($_POST['startTemplateUrl']) && !empty($_POST['startTemplateUrl'])) {
							$startTemplateUrl = MaxxFunctions::sanitizeFileName($_POST['startTemplateUrl']);
							$html = file_get_contents($startTemplateUrl);
						}else if (isset($_POST['html'])){
							$html = substr($_POST['html'], 0, 1024 * 1024 * 2);
						}
						$filePath = "templates/".$folder."/newsletter"."/".$filename;
						Storage::disk('local')->put($filePath, $html);
						NewsletterDraft::where('id',$checkdraft->id)->update(['newsletter_file'=>$filename,'save_template'=>$checkdraft->template_id]);
						return response()->json(['status'=>'success','type'=>'newsletter']);
			    	}elseif($data['type'] =="landing-page"){
			    		$folder = Auth::user()->id;
			    		$actions = array('lp#tp','tp#lp','lp#save-next','tp#save-next');
			    		if(isset($data['actiontype']) && in_array($data['actiontype'],$actions)){
		    				$explodeActions = explode('#',$data['actiontype']);
			    			$saveAction = $explodeActions[0];
			    			$redirect  = $explodeActions[1];
			    			$checkLanding = LandingPage::join('templates','templates.id','=','landing_pages.template_id')->select('landing_pages.*','templates.folder','templates.thankyou_filename','templates.is_thankyou','templates.filename')->where('user_id',Auth::user()->id)->where('unique_id',$uniqid)->first();
					    	if($saveAction =="lp" && !empty($checkLanding->landing_file)){
					    		$filename = $checkLanding->landing_file;
					    	}elseif($saveAction =="tp" && !empty($checkLanding->thankyou_file)){
					    		$filename = $checkLanding->thankyou_file;
					    	}else{
					    		$filename =  $checkLanding->folder.$data['ref'].time().".html";
					    	}
					    	$html = "";
							if (isset($_POST['startTemplateUrl']) && !empty($_POST['startTemplateUrl'])) {
								$startTemplateUrl = MaxxFunctions::sanitizeFileName($_POST['startTemplateUrl']);
								$html = file_get_contents($startTemplateUrl);
							}else if (isset($_POST['html'])){
								$html = substr($_POST['html'], 0, 1024 * 1024 * 2);
							}
							$filePath = "templates/".$folder."/landing-pages"."/".$filename;
	 						Storage::disk('local')->put($filePath, $html);
	 						if($saveAction =="lp"){
	 							LandingPage::where('id',$checkLanding->id)->update(['landing_file'=>$filename]);
	 						}elseif($saveAction =="tp"){
	 							LandingPage::where('id',$checkLanding->id)->update(['thankyou_file'=>$filename]);
	 						}
							return response()->json(['status'=>'success','type'=>'landing-page','redirect'=>$redirect,'ref'=>$uniqid]);
			    		}else{
			    			return response()->json(['status'=>'failed']);
			    		}
			    	}
			    }else{
			    	return response()->json(['status'=>'failed']);
			    }
            }else{
            	return response()->json(['status'=>'failed']);
            }
    	}
    }
}
