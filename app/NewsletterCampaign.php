<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterCampaign extends Model
{
    //
    public function draft(){
    	return $this->belongsTo('App\NewsletterDraft','newsletter_draft_id')->select('id','message_name','subject','from_name','from_email');
       }
}
