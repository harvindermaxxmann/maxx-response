<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    public function feature(){
    	return $this->belongsTo('App\Feature','feature_id');
    }

    public function template(){
    	return $this->belongsTo('App\Template','template_id');
    }
}
