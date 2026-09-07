<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\SmsCampaign;
use App\SmsCampaignStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
class SmsCampaign extends Model
{
    //
    protected $fillable = ['id','user_id','linked_list_id','sender_id','created_at','updated_at','content','campaign_name'];

    public function totalsms(){
    	return $this->hasMany('App\SmsCampaignStatus');
    }

    public function linkedlist(){
        return $this->belongsTo('App\LinkedList','linked_list_id');
    }

    public static function getsummary($fromdate,$todate){
    	$campagins = SmsCampaign::select('id')->where('user_id',Auth::user()->id);
    	if($fromdate !=""){
    		$campagins = $campagins->whereDate('created_at','>=',$fromdate);
    	}
    	if($todate !=""){
    		$campagins = $campagins->whereDate('created_at','<=',$todate);
    	}
    	$campagins = $campagins->get();
    	$campagins = Arr::flatten(json_decode(json_encode($campagins),true));
    	$totalsms = SmsCampaignStatus::whereIn('sms_campaign_id',$campagins)->count();
    	$totalsmsSent = SmsCampaignStatus::whereIn('sms_campaign_id',$campagins)->where('sStatus','DELIVRD')->count();
        $totalsmsPending = SmsCampaignStatus::whereIn('sms_campaign_id',$campagins)->where('sStatus','!=','DELIVRD')->count();
    	$totalcredit = SmsCampaignStatus::whereIn('sms_campaign_id',$campagins)->where('sStatus','DELIVRD')->sum('iCostPerSms');
    	return array('totalSms'=>$totalsms,'totalsmsSent'=>$totalsmsSent,'totalcredit'=>$totalcredit,'totalsmsPending' => $totalsmsPending);
    }

    public static function getCampaignnSummary($campaginid){
        $campagins = SmsCampaign::select('id')->where('user_id',Auth::user()->id);
        $campagins = $campagins->where('id',$campaginid)->get();
        $campagins = Arr::flatten(json_decode(json_encode($campagins),true));
        $totalsms = SmsCampaignStatus::whereIn('sms_campaign_id',$campagins)->count();
        $totalsmsSent = SmsCampaignStatus::whereIn('sms_campaign_id',$campagins)->where('sStatus','DELIVRD')->count();
        $totalsmsPending = SmsCampaignStatus::whereIn('sms_campaign_id',$campagins)->where('sStatus','!=','DELIVRD')->count();
        $totalcredit = SmsCampaignStatus::whereIn('sms_campaign_id',$campagins)->where('sStatus','DELIVRD')->sum('iCostPerSms');
        return array('totalSms'=>$totalsms,'totalsmsSent'=>$totalsmsSent,'totalcredit'=>$totalcredit,'totalsmsPending'=>$totalsmsPending);
    }
}
