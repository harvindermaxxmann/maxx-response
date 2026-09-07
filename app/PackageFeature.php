<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageFeature extends Model
{
    //
    public static function checkfeatureExists($pacakgeid,$featureid){
    	$check = PackageFeature::where(['package_id'=>$pacakgeid,'feature_id'=>$featureid])->count();
    	if($check==0){
    		return 'no';
    	}else{
    		return 'yes';
    	}
    }

    public static function selectedFeatures($pacakgeid,$featureid){
    	$selectedfeature = PackageFeature::where(['package_id'=>$pacakgeid,'feature_id'=>$featureid])->first();
    	$selectedfeature = json_decode(json_encode($selectedfeature),true);
    	return $selectedfeature;
    }
}
