<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterDraft extends Model
{
    //
    public function template(){
    	return $this->belongsto('App\Template','template_id');
    }

    public function linkedlist(){
    	return $this->belongsto('App\LinkedList','linked_list_id');
    }

    public function page(){
    	return $this->belongsTo('App\Page','page_id');
    }
}
