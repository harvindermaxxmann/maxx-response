<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
	protected $fillable = ['id','user_id','linked_list_id','first_name','last_name','email','company_name','phone','title','job_title','opt_in','confirmed_time','privacy_policy','created_at','updated_at'];

    public function listname(){
    	return $this->belongsTo('App\LinkedList','linked_list_id');
    }
}
