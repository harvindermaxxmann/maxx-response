<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\UserSenderId;
use Redirect;
use App\LinkedList;
use App\MaxxFunctions;
//use Illuminate\Support\Facades\Input;
use App\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\SmsCampaign;
use App\Input;
use App\SmsCampaignStatus;
use App\LandingPage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;


class CampaignController extends Controller
{
    //
	public function sms(Request $request){
		Session::put('menuactive','sms');
		$title = 'SMS Campaign';
		$campaigns = SmsCampaign::with(['linkedlist'=>function($query){
			$query->withcount(['contacts'=>function($querys){
				$querys->where('phone','!=','');
			}]);

		}])->withCount('totalsms')->where('is_delete','no')->where('user_id',Auth::user()->id)->orderby('created_at','DESC');
		$fromdate = ""; $todate="";
		if($request->isMethod('get')){
			$data = $request->all();
			if(isset($data['from']) && !empty($data['from'])){
				$fromdate = $data['from'];
				$campaigns = $campaigns->whereDate('created_at','>=',$fromdate);
			}
			if(isset($data['to']) && !empty($data['to'])){
				$todate = $data['to'];
				$campaigns = $campaigns->whereDate('created_at','<=',$todate);
			}
		}
		$campaigns = $campaigns->get();
		// dd($campaigns);
		//echo "<pre>"; print_r(json_decode(json_encode($campaigns),true)); die;
		return view('front.sms.sms')->with(compact('campaigns','title','fromdate','todate'));
	}

	public function deleteSmsCampaign($campaignid){
		SmsCampaign::where('id',$campaignid)->where('user_id',Auth::user()->id)->update(['is_delete'=>'yes']);
		return redirect()->back()->with('flash_message_success','Sms Campaign has been deleted successfully');
	}

	public function smsCampaign(Request $request){
		Session::put('menuactive','sms');
		if($request->ajax()){
			$data = $request->all();
			$validator = Validator::make($request->all(), [
	            'campaign_name' => 'required',
	            'sender_id' => 'required',
	            'content' => 'required|max:160',
	            'list' => 'required|max:50',
	            'accept' => 'required',
	        ],[
	        	'sender_id.required'=>'Please Select Sender Id',
	        	'list.required'=>'Please select List',
	        	'accept.required'=>'Please accept our terms & conditions',
	        ]);
	        if ($validator->passes()) {
	        	//check if content textarea contains only url
	        	if(filter_var($data['content'], FILTER_VALIDATE_URL)) {
					return response()->json(['status'=>false,'error'=>array('Please add some more content with url. We cannot accpet only url')]);
				}
	        	if($data['list'] =="add-new"){
	        		$validator = Validator::make($request->all(), [
			            'list_name' => 'required|max:20|unique:linked_lists',
			            'csv_file' => 'required|mimes:csv,txt',
			        ],[
			        	'list_name.required'=>'Please enter List name',
			        	'csv_file.mimes'=>'Please select only csv files format',
			        ]);
			        if ($validator->passes()) {
			        	//Upload Csv File firstly
			        	if($request->hasFile('csv_file')){
			        		//$csvfile = Input::file('csv_file');
							$csvfile = $request->file('csv_file');
			        		$handle = fopen($csvfile,"r");
                    		$header = fgetcsv($handle, 0, ',');
			        		/*$file_name = $csvfile->getClientOriginalName();
                            $csvfile->move('sms-contacts',$file_name);
                            $results = Excel::load('sms-contacts/'.$file_name)->get();
                            $countrows = $results->count();*/
                        	if(in_array('name',$header) && in_array('email',$header)  && in_array('phone',$header) && in_array('address',$header) ){
                        		$file_name = $csvfile->getClientOriginalName();
	                            $csvfile->move('files',$file_name);
	                            $results = Excel::load('files/'.$file_name)->get();
	                            $countrows = $results->count();
	                            $contacts = json_decode(json_encode($results),true);
	                            if($countrows<=500){
	                            	if($data['sender_id']=="MXMCMS"){ //default maxxman sender id
		                          		if($countrows > 10)
		                          		return response()->json([
							    			'status'=>false,
							    			'error'=>array('We are sorry this sender Id '.$data['sender_id'].' allows you to send only 10 SMS'),
							    		]);
		                          	}
	                            	//Create Linked LIst
							    	$linkedList = new LinkedList;
							    	$linkedList->type ="sms";
							    	$linkedList->user_id = Auth::user()->id;
							    	$linkedList->list_name = $data['list_name'];
							    	$linkedList->save();
							    	$linkedlistid = DB::getPdo()->lastInsertId();
								    foreach($contacts as $contactdetail){
	                                    if(!empty($contactdetail['email']) && filter_var($contactdetail['email'], FILTER_VALIDATE_EMAIL) && is_numeric($contactdetail['phone']) && preg_match("/^[6-9][0-9]{9}$/",$contactdetail['phone']) && strlen($contactdetail['phone'])==10){
	                                        $exists = Contact::where('email',$contactdetail['email'])->where('linked_list_id',$linkedlistid)->where('user_id',Auth::user()->id)->first();
	                                        if($exists){
	                                            $contact = Contact::find($exists->id);
	                                        }else{
	                                            $contact = new Contact;
	                                        }
	                                        $contact->user_id = Auth::user()->id;
	                                        $contact->linked_list_id = $linkedlistid;
	                                        $contactArray = array('email','name','phone','company_name','address','job_title','country','state','city','opt_in','pincode');
	                                        foreach($contactArray  as $contactArr){
	                                            if(isset($contactdetail[$contactArr]) && !empty($contactdetail[$contactArr])){
	                                                if($contactArr =="phone"){
	                                                    $contact->$contactArr = sprintf($contactdetail[$contactArr]);
	                                                }else{
	                                                    $contact->$contactArr = $contactdetail[$contactArr];
	                                                }
	                                            }
	                                        }
	                                        $contact->save();
	                                    }
	                                }
	                                //Create SMS Campaign data
							    	$smscampaign = array('user_id'=>Auth::user()->id,'linked_list_id'=>$linkedlistid,'sender_id'=>$data['sender_id'],'content'=>$data['content'],'campaign_name'=>$data['campaign_name']);
							    	SmsCampaign::create($smscampaign);
							    	$smscampaignid = DB::getPdo()->lastInsertId();
							    	return response()->json([
						    			'status'=>true,
						    			'message'=>'Please wait we are sending sms.',
						    			'smscampaignid'=>$smscampaignid
						    		]);
	                            }else{
	                            	return response()->json(['status'=>false,'error'=>array('Mobile Numbers limit exceeded in csv file. Please add mobile numbers less then or equal to 500')]);
	                            }
                        	}else{
                        		return response()->json(['status'=>false,'error'=>array('Your CSV files having unmatched Columns to our database...Your columns must be in this sequence <strong> name,email,address,phone</strong> only')]);
                        	}
					    	
			        	}else{
			        		return response()->json(['status'=>false,'error'=>array('Something Went Wrong')]);
			        	}
			        }else{
		        		return response()->json(['status'=>false,'error'=>$validator->errors()->all()]);
			        }
	        	}else{
	        		// user selects the list id
	        		$getlist = LinkedList::select('id')->where(['user_id'=> Auth::user()->id,'list_name'=>$data['list']])->first();
	        		if($getlist){
	        			//Get Contacts
	        			$getContactscount = Contact::select('phone')->where('linked_list_id',$getlist->id)->where('phone','!=','')->count();
	        			if($data['sender_id']=="MXMCMS"){
	        				$canSend = 10;
	        			}else{
	        				$canSend = 500;
	        			}
	        			if($getContactscount <= $canSend){
							//Create SMS Campaign data
					    	$smscampaign = array('user_id'=>Auth::user()->id,'linked_list_id'=>$getlist->id,'sender_id'=>$data['sender_id'],'content'=>$data['content'],'campaign_name'=>$data['campaign_name']);
					    	SmsCampaign::create($smscampaign);
					    	$smscampaignid = DB::getPdo()->lastInsertId();
					    	return response()->json([
				    			'status'=>true,
				    			'message'=>'Please wait we are sending sms.',
				    			'smscampaignid'=>$smscampaignid
				    		]);
	        			}else{
	        				return response()->json([
				    			'status'=>false,
				    			'error'=>array('We are sorry this sender Id '.$data['sender_id'].' allows you to send only '.$canSend. ' SMS'),
				    		]);
	        			}
	        		}else{
	        			return response()->json(['status'=>false,'error'=>array('Something Went Wrong. Please try again')]);
	        		}
	        	}
	        }
	        return response()->json(['status'=>false,'error'=>$validator->errors()->all()]);
		}
		$checksenderid = UserSenderId::where('user_id',Auth::user()->id)->first();
		$linkedlists = LinkedList::withCount('contacts')->where('user_id',Auth::user()->id)->orderby('id','Desc')->get();
		$userlandingPages = LandingPage::where(['user_id'=>Auth::user()->id])->where('max_subdomain','!=','')->select('max_subdomain')->get();
		$title="SMS Campaign";
		return view('front.sms.sms-campaign')->with(compact('title','checksenderid','linkedlists','userlandingPages'));
	}

	public function sendSmsToContacts(Request $request){
		if($request->ajax()){
			if($this->smsmode=="live"){
				$data = $request->all();
				$details = SmsCampaign::where('id',$data['smscampaignid'])->first();
				$details = json_decode(json_encode($details),true);
				//get Mobile Numbers
				$mobileNumbers = Contact::select('phone')->where('linked_list_id',$details['linked_list_id'])->where('phone','!=','')->get();
				$mobileNumbers = json_decode(json_encode($mobileNumbers),true);
	          	$uponeLevelnumbers = Arr::flatten($mobileNumbers);
		    	$filterMobileNumbers = array_filter(array_unique($uponeLevelnumbers));
		    	$finalMobileNumbers = preg_grep("/^[6-9][0-9]{9}$/", $filterMobileNumbers);
		    	$smsMobileNumbers = preg_filter('/^/', '91', $finalMobileNumbers);
		    	$implodeMobileNumbers = implode(',',$smsMobileNumbers); 
		    	//echo "<pre>"; print_r($implodeMobileNumbers); die;
				/*Code for SMS Script Start*/
	                $request ="";
	                $param['username']="maxxmannscrub";
	                $param['password']="3bnalzhh";
	                $param['type']=0;
	                $param['dlr']=1;
	                $param['destination']=$implodeMobileNumbers;
	                $param['source']=$details['sender_id'];
	                $param['message']=$details['content'];
	                foreach($param as $key=>$val) {
	                    $request.= $key."=".urlencode($val);
	                    $request.= "&";
	                }
	                $request = substr($request, 0, strlen($request)-1);
	                $url ="http://sms6.rmlconnect.net/bulksms/bulksms?".$request;
	                $ch = curl_init($url);
	                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	                $result = curl_exec($ch);
	                /*Code for SMS Script Ends*/
	                if(!empty($result)){
	                	$explodeResult = explode(',',$result);
						foreach($explodeResult as $sendStatus){
							$explodeStatus = explode('|',$sendStatus);
							if(isset($explodeStatus[0])){
								$smscampaignStatus = new SmsCampaignStatus;
								$smscampaignStatus->sms_campaign_id = $data['smscampaignid'];
								$smscampaignStatus->status = $explodeStatus[0];
								if(isset($explodeStatus[1])){
									$explodeSmsDetails = explode(':',$explodeStatus[1]);
									$smscampaignStatus->mobile = $explodeSmsDetails[0];
									if(isset($explodeSmsDetails[1])){
										$smscampaignStatus->message_id = $explodeSmsDetails[1];
									}
								}
								$smscampaignStatus->save();
							}
						}
	                }
	            curl_close($ch);
			}
           	return response()->json(['status'=>true,'message'=>array('Sms has been run successfully.')]);
		}
	}

	public function resendSmsCampaign(Request $request){
		if($request->ajax()){
			$data = $request->all();
			$validator = Validator::make($request->all(), [
	            'campaign_name' => 'required',
	            'campaign_id' => 'required|numeric',
	            'content' => 'required|max:160',
	        ]);
	        if ($validator->passes()) {
	        	$campaignDetails = SmsCampaign::where('id',$data['campaign_id'])->where('user_id',Auth::user()->id)->first();
	        	if($campaignDetails){
	        		//Create SMS Campaign data
			    	$smscampaign = array('user_id'=>Auth::user()->id,'linked_list_id'=>$campaignDetails->linked_list_id,'sender_id'=>$campaignDetails->sender_id,'content'=>$data['content'],'campaign_name'=>$data['campaign_name']);
			    	SmsCampaign::create($smscampaign);
			    	$smscampaignid = DB::getPdo()->lastInsertId();
				    if($this->smsmode=="live"){
						$data = $request->all();
						$details = SmsCampaign::where('id',$smscampaignid)->first();
						$details = json_decode(json_encode($details),true);
						//get Mobile Numbers
						$mobileNumbers = Contact::select('phone')->where('linked_list_id',$details['linked_list_id'])->where('phone','!=','')->get();
						$mobileNumbers = json_decode(json_encode($mobileNumbers),true);
			          	$uponeLevelnumbers = Arr::flatten($mobileNumbers);
				    	$filterMobileNumbers = array_filter(array_unique($uponeLevelnumbers));
				    	$finalMobileNumbers = preg_grep("/^[6-9][0-9]{9}$/", $filterMobileNumbers);
				    	$smsMobileNumbers = preg_filter('/^/', '91', $finalMobileNumbers);
				    	$implodeMobileNumbers = implode(',',$smsMobileNumbers); 
				    	//echo "<pre>"; print_r($implodeMobileNumbers); die;
						/*Code for SMS Script Start*/
			                $request ="";
			                $param['username']="maxxmannscrub";
			                $param['password']="3bnalzhh";
			                $param['type']=0;
			                $param['dlr']=1;
			                $param['destination']=$implodeMobileNumbers;
			                $param['source']=$details['sender_id'];
			                $param['message']=$details['content'];
			                foreach($param as $key=>$val) {
			                    $request.= $key."=".urlencode($val);
			                    $request.= "&";
			                }
			                $request = substr($request, 0, strlen($request)-1);
			                $url ="http://sms6.rmlconnect.net/bulksms/bulksms?".$request;
			                $ch = curl_init($url);
			                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			                $result = curl_exec($ch);
			                /*Code for SMS Script Ends*/
			                if(!empty($result)){
			                	$explodeResult = explode(',',$result);
								foreach($explodeResult as $sendStatus){
									$explodeStatus = explode('|',$sendStatus);
									if(isset($explodeStatus[0])){
										$smscampaignStatus = new SmsCampaignStatus;
										$smscampaignStatus->sms_campaign_id = $smscampaignid;
										$smscampaignStatus->status = $explodeStatus[0];
										if(isset($explodeStatus[1])){
											$explodeSmsDetails = explode(':',$explodeStatus[1]);
											$smscampaignStatus->mobile = $explodeSmsDetails[0];
											if(isset($explodeSmsDetails[1])){
												$smscampaignStatus->message_id = $explodeSmsDetails[1];
											}
										}
										$smscampaignStatus->save();
									}
								}
			                }
			            curl_close($ch);
					}
	           		return response()->json(['status'=>true,'message'=>array('Sms has been run successfully.')]);
	        	}else{
	        		return response()->json(['status'=>false,'error'=>array('Something Went Wrong')]);
	        	}
	        }
	        return response()->json(['status'=>false,'error'=>$validator->errors()->all()]);
		}
	}

	public function createSmsSenderId(Request $request){
		if($request->ajax()){
			$data = $request->all();
	    	$validator = Validator::make($request->all(), [
	            'sample1' => 'required|max:6|min:6|not_in:MXMCMS',
	            'sample2' => 'max:6|min:6|not_in:MXMCMS',
	            'sample3' => 'max:6|min:6|not_in:MXMCMS',
	            'business_name' => 'required|max:50',
	            'website_url' => 'required|url',
	            'email' => 'required|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i|max:255',
	        ],[
	        	'sample1.required'=>'Sender Sample 1 is required',
	        	'sample1.not_in'=>'You cannot choose default MXMCMS as sender id in sample 1',
	        	'sample2.not_in'=>'You cannot choose default MXMCMS as sender id in sample 2',
	        	'sample3.not_in'=>'You cannot choose default MXMCMS as sender id in sample 3',
	        	'email.regex'=>'Email must be a valid email address',
	        	'website_url.url'=>'Website url must include (http or https) protocol',
	        ]);
	        if ($validator->passes()) {
	        	//Check Sample
	        	$sample1 = $data['sample1'];
	        	$columns = ['sample1','sample2','sample3','sender_id'];
	        	$sample1check = UserSenderId::where(function($q) use($columns, $sample1) {
                        foreach ($columns as $field)
                           $q->orWhere($field, 'like', "%{$sample1}%");
                })->count();
                $sample2check = 0;
	        	if(!empty($data['sample2'])){
	        		$sample2 = $data['sample2'];
	        		$sample2check = UserSenderId::where(function($q) use($columns, $sample2) {
                        foreach ($columns as $field)
                           $q->orWhere($field, 'like', "%{$sample2}%");
                	})->count();
	        	}
	        	$sample3check = 0;
	        	if(!empty($data['sample3'])){
	        		$sample3 = $data['sample3'];
	        		$sample3check = UserSenderId::where(function($q) use($columns, $sample3) {
                        foreach ($columns as $field)
                           $q->orWhere($field, 'like', "%{$sample3}%");
                	})->count();
	        	}
	        	if($sample1check !=0){
	        		return response()->json(['status'=>false,'error'=>array($data['sample1']. " has already been taken")]);
	        	}
	        	if($sample2check !=0){
	        		return response()->json(['status'=>false,'error'=>array($data['sample2']. " has already been taken")]);
	        	}
	        	if($sample3check !=0){
	        		return response()->json(['status'=>false,'error'=>array($data['sample3']. " has already been taken")]);
	        	}
	        	//Check Request Already received
	        	$check = UserSenderId::where('user_id',Auth::user()->id)->count();
	        	if($check==0){
	        		//Now pushing data 
		        	$smsid = new UserSenderId;
		        	$smsid->sample1  = strtoupper($data['sample1']);
		        	$smsid->sample2  = strtoupper($data['sample2']);
		        	$smsid->sample3  = strtoupper($data['sample3']);
		        	$smsid->business_name  = $data['business_name'];
		        	$smsid->website_url  = $data['website_url'];
		        	$smsid->email  = $data['email'];
		        	$smsid->user_id  = Auth::user()->id;
		        	$smsid->status  = 0;
		        	$smsid->save();
		        	Session::put('senderThanks','active');
					return response()->json(['status'=>true]);
	        	}else{
	        		return response()->json(['status'=>false,'error'=>array("We have already received your previous request. Kindly wait for 1 or 3 business days")]);
	        	}
			}
			return response()->json(['status'=>false,'error'=>$validator->errors()->all()]);
		}
	}

	public function senderThanks(){
		if(Session::has('senderThanks')){
			Session::forget('senderThanks');
			return view('front.sms.thanks');
		}else{
			return redirect()->to('sms-campaign');
		}
	}

	public function exportSmsCampaign($campaignid){
		$campaignDetails = SmsCampaign::with(['linkedlist'=>function($query){
			$query->withcount(['contacts'=>function($querys){
				$querys->where('phone','!=','');
			}]);
		}])->where('id',$campaignid)->where('user_id',Auth::user()->id)->first();
		//dd(json_decode(json_encode($campaignDetails)));
		if(!$campaignDetails){
			abort(404);
		}
        $headers = array(
            'Content-Type'        => 'text/csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=Campaign.csv',
            'Expires'             => '0',
            'Pragma'              => 'public',
        );
        $response = new StreamedResponse(function() use($campaignid,$campaignDetails){
            // Open output stream
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, ['Campaign Name :-',$campaignDetails->campaign_name]);
            fputcsv($handle, ['Content :-',$campaignDetails->content]);
            fputcsv($handle, ['Created On :-',date('M d, Y h:ia',strtotime($campaignDetails->created_at))]);
            fputcsv($handle, ['List Name :-',$campaignDetails->linkedlist->list_name.' ('.$campaignDetails->linkedlist->contacts_count.')']);
            fputcsv($handle, ['']);
            fputcsv($handle, ['Mobile Number','Status','Cost Per Sms']);
            $exportData  = SmsCampaign::with('totalsms')->where('id',$campaignid)->where('user_id',Auth::user()->id);
            $exportData = $exportData->chunk(500, function($campaigns) use($handle) {
                foreach ($campaigns as $campaign) {  
                	foreach($campaign->totalsms as $sendCampaign) 
                    fputcsv($handle, [
                        $sendCampaign->mobile,
                        $sendCampaign->sStatus,
                        $sendCampaign->iCostPerSms,
                    ]);
                }
            });
            fclose($handle);
        },200, $headers);
        return $response->send();
    }

    public function campaignDetail($campaignid){
    	$title = "Campaign Details";
    	$campaignDetails  = SmsCampaign::with('totalsms')->where('id',$campaignid)->where('user_id',Auth::user()->id)->first();
    	if(!$campaignDetails){
			abort(404);
		}
    	return view('front.sms.campaign-detail')->with(compact('title','campaignDetails'));
    }

	public function getTinyUrl(Request $request){
		if($request->isMethod('post')){
			$data = $request->all();
			$newurl = MaxxFunctions::tinyUrl($data['url']);
			return $newurl;
		}
	}

	public function smsCampaignList(){
		return view('front.sms.sms-campaign-list');
	}
}
