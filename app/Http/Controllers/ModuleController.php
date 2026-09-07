<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
class ModuleController extends Controller
{
    //
    public static function getModules(){
        if(Session::get('adminSession')['type']=="super"){
            $allModules = Module::with('undermodules')->where(['parent_id'=>'ROOT','status'=>1])->orderBy('sortorder','asc')->get();
            $allModules = json_decode(json_encode($allModules),true);
            return $allModules;
        }else{
            $getAdminModules = DB::table('role_permissions')->where(['role_id'=>Session::get('adminSession')['role_id'],'view_access'=>'1'])->select('module_id')->get();
            $getAdminModules = Arr::flatten(json_decode(json_encode($getAdminModules),true));
            $allModules = Module::with(['undermodules'=>function($query) use($getAdminModules){
                $query->whereIn('id',$getAdminModules);
            }])->where(['parent_id'=>'ROOT','status'=>1])->orderBy('sortorder','asc')->get();
            $allModules = json_decode(json_encode($allModules),true);
            return $allModules;
        }
    }
}
