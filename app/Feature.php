<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\Feature;
use Illuminate\Support\Facades\DB;
class Feature extends Model
{
    //
    public static function features(){
    	$features = Feature::with(['subfeatures'])->select('id','name','parent_id','slug')->where('parent_id','ROOT')->get();
        $features = json_decode(json_encode($features),true);
        return $features;
    }
    
    public static function getfeatures(){
        $features = Feature::with(['subfeatures'])->select('id','name','parent_id','slug')->where('parent_id','ROOT')->where('status',1)->get();
        $features = json_decode(json_encode($features),true);
        return $features;
    }

    public function subfeatures(){
    	return $this->hasMany('App\Feature','parent_id')->select('id','name','parent_id');
    }

    public static function featureTypes($slug){
    	$parentid = DB::table('features')->where('slug',$slug)->select('id')->first();
    	$types = DB::table('features')->where('parent_id',$parentid->id)->get();
    	$types = json_decode(json_encode($types),true);
    	return $types;
    }

    public static function featureids($slug){
        $getCatdetail = Feature::with(['subfeatures'=>function($query){
                $query->with('subfeatures');
            }])->where('slug',$slug)->where('status',1)->select('id','name','description','slug')->first();
        $getCatdetail = json_decode(json_encode($getCatdetail),true);
        $featureids =array();
        if($getCatdetail){
            $featureids[] = $getCatdetail['id'];
            foreach($getCatdetail['subfeatures'] as $subcat){
                $featureids[] = $subcat['id'];
                foreach($subcat['subfeatures'] as $subsubcat){
                    $featureids[] = $subsubcat['id'];
                }
            }
        }
        $resp = $featureids;
        return $resp;
    }
}
