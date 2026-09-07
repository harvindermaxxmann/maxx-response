<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    public static function plans(){
    	$plans = Discount::get();
    	$plans = json_decode(json_encode($plans),true);
    	return $plans; 
    }
}
