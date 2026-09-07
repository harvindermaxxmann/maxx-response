<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\LinkedList;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class LinkedList extends Model
{
    //
    public static function lists(){
    	$lists = LinkedList::where('user_id',FacadesAuth::user()->id)->orderby('id','DESC')->get();
    	$lists = json_decode(json_encode($lists),true);
    	return $lists;
    }

    public function contacts(){
    	return $this->hasMany('App\Contact','linked_list_id');
    }
}
