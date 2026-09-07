<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\RolePermission;
class RolePermission extends Model
{
    //
    public static function roledetails($roleid,$moduleid){
    	$view = ""; $edit = ""; $delete = "";
    	$checkAccess = RolePermission::where('role_id',$roleid)->where('module_id',$moduleid)->first();
    	if($checkAccess){
    		if($checkAccess->view_access ==1){
	    			$view = "checked";
			}
			if($checkAccess->edit_access == 1){
				$edit = "checked";
			}
			if($checkAccess->delete_access == 1){
				$delete = "checked";
			}
    	}
		$access = array('view' =>$view,'edit' => $edit,'delete' =>$delete);
    	return $access;
    }
}
