<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\NewsletterDraft;
use Auth;
use App\LandingPage;
class MaxxFunctions extends Model
{
    //
    public static function checkValidUniqId($type,$uniqid){
        $check =0;
        if($type=="newsletter"){
            $check = NewsletterDraft::where(['user_id'=>Auth::user()->id,'unique_id'=>$uniqid])->count();
        }elseif($type=="landing-page"){
            $check = LandingPage::where(['user_id'=>Auth::user()->id,'unique_id'=>$uniqid])->count();
        }
    	if($check == 0){
    		return 'false';
    	}else{
    		return 'true';
    	}
    }

    public static function validList($listid){
    	$checkvalidList = LinkedList::where(['user_id'=>Auth::user()->id,'id'=>$listid])->count();
    	if($checkvalidList ==0){
    		return false;
    	}else{
    		return true;
    	}
    }

    public static function tinyUrl($url)  {  
        $ch = curl_init();  
        $timeout = 5;  
        curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
        $data = curl_exec($ch);  
        curl_close($ch);  
        return $data;  
    } 
}
