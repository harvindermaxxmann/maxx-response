<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterJob extends Model
{
    //
    public function campaign(){
    	return $this->belongsTo('App\NewsletterCampaign','newsletter_campaign_id')->with('draft');
    }

    public function user(){
    	return $this->belongsTo('App\User','created_by')->select('id','name','email');
    }
}
