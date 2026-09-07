<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Feature;
use App\PackageListSize;
use App\Discount;
class Package extends Model
{
    //
	public function features(){
		return $this->belongsToMany('App\PackageFeature', 'package_features', 'package_id', 'feature_id');
	}

    public function listsize(){
    	return $this->hasMany('App\PackageListSize','package_id');
    }

    public static function packagefeatures(){
    	$features = Feature::with(['subfeatures'])->has('subfeatures','>=',1)->select('id','name','parent_id')->where('parent_id','ROOT')->get();
        $features = json_decode(json_encode($features),true);
        return $features;
    }

    public static function checkValidPacakge($data){
        $checkpackage = PackageListSize::where(['package_id'=>$data['package'],'list_size'=>$data['listsize']])->count();
        if($checkpackage > 0){
            $checkplan = Discount::where('value',$data['plan'])->count();
            if($checkplan > 0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
