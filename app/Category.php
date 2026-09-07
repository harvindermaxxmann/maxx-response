<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\Category;
class Category extends Model
{
    //
    public static function categories($type){
    	$categories = Category::where('type',$type)->get();
    	$categories = json_decode(json_encode($categories),true);
    	return $categories;
    }

    public static function cats(){
    	$categories = Category::with(['subcats'])->select('id','name','parent_id')->where('parent_id','ROOT')->get();
        $categories = json_decode(json_encode($categories),true);
        return $categories;
    }

    public function subcats(){
    	return $this->hasMany('App\Category','parent_id')->select('id','name','parent_id');
    }
}
