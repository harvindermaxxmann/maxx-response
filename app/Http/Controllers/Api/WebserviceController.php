<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SmsCampaignStatus;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class WebserviceController extends Controller
{
    //
    public function deliveryReports(Request $request){
    	if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'sSender'    => 'required',
                'sMobileNo'    => 'required',
                'sStatus'   =>'required',
                'dtSubmit'   =>'required',
                'dtDone'   =>'required',
                'sMessageId'   =>'required',
                'iCostPerSms'   =>'required',
                'iCharge'   =>'required',
                'iMCCMNC'   =>'required',
                'ErrCode'   =>'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = Arr::flatten(json_decode(json_encode($validator->messages()),true));
                $messages = implode(',', $errors);
                return response()->json([
                    'status'=>422,
                    'message'=>$messages
                ]);
            }
            //Update Delivery Report Status
            $details = SmsCampaignStatus::join('sms_campaigns','sms_campaigns.id','=','sms_campaign_statuses.sms_campaign_id')->where(['sms_campaigns.sender_id'=>$data['sSender'],'sms_campaign_statuses.mobile'=>$data['sMobileNo'],'sms_campaign_statuses.message_id'=>$data['sMessageId']])->update(['sStatus'=>$data['sStatus'],'dtSubmit'=>$data['dtSubmit'],'dtDone'=>$data['dtDone'],'iCostPerSms'=>$data['iCostPerSms'],'iCharge'=>$data['iCharge'],'iMCCMNC'=>$data['iMCCMNC'],'ErrCode'=>$data['ErrCode']]);
	        $status = "Results: " . print_r( $_REQUEST, true );
	        /*mail('kunalmahajan710@gmail.com','Test',$status,'From: smtpmail@maxxmannsupport.com');*/
    		return response()->json([
    			'status' =>200,
    			'message'=>'ok',

    		]);
    	}else{
    		return response()->json([
    			'status' =>404,
    			'message'=>'Unauthorized!.... Only Post method accepted',

    		]);
    	}
    }
}
