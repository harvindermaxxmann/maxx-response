<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Package;
use App\Feature;
use App\PackageListSize;
use App\PackageFeature;
use App\Discount;
use App\CouponCode;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
class PackageController extends Controller
{
    //
    public function packages(Request $Request){
        Session::put('active',4); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('packages');
            if(!empty($data['name'])){
                $querys = $querys->where('package_name','like','%'.$data['name'].'%');
            }
            if(!empty($data['description'])){
                $querys = $querys->where('description','like','%'.$data['description'].'%');
            }
            if(!empty($data['no_of_users'])){
                $querys = $querys->where('number_of_users',$data['no_of_users']);
            }
            $querys = $querys->OrderBy('id','DESC');
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                    ->skip($iDisplayStart)->take($iDisplayLength)
                    ->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $package){
                $checked='';
                if($package['status']==1){
                    $checked='on';
                }else{
                    $checked='off';
                }
                $actionValues='<a title="Edit package" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-package/'.$package['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
                $num = ++$i;
                $records["data"][] = array(     
                    $num,
                    $package['package_name'],
                    $package['description'],
                    $package['number_of_users'],
                    '<div  id="'.$package['id'].'" rel="packages" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Packages";
        return View::make('admin.packages.packages')->with(compact('title'));
    }

    public function addEditPackage(Request $request,$pid=null){
    	if($pid==""){
    		$title="Add Package";
    		$package = new Package;
    		$packagedata = array();
    		$selFeatures = array();
    	}else{
    		$title="Update Package";
    		$package = Package::with('listsize')->find($pid);
    		
    		$packagedata = json_decode(json_encode($package),true);
    		$selFeatures = PackageFeature::where('package_id',$pid)->select('feature_id')->get();
    		$selFeatures = Arr::flatten(json_decode(json_encode($selFeatures),true));
    	}
    	if($request->isMethod('post')){
    		$data = $request->all();
            //echo "<pre>"; print_r($data); die;
    		$package->package_name =$data['package_name'];
    		$package->description =$data['description'];
            $package->number_of_users =$data['number_of_users'];
    		$package->type =$data['type'];
            if($data['type']=="free"){
                $package->no_of_days =$data['no_of_days'];
            }
    		if(!$packagedata){
                $package->status = 1;
                $message = $data['package_name'] ." Package has been added successfully.";
    			$pid = DB::getPdo()->lastInsertId();
    		}else{
                $message =$data['package_name']." Package has been updated successfully.";
            }
            $package->save();
    		if(isset($data['list_size'])){
    			foreach($data['list_size'] as $lkey => $listsize){
	    			if(isset($data['list_ids'][$lkey])){
	    				$listSize = PackageListSize::find($data['list_ids'][$lkey]);
	    			}else{
	    				$listSize = new PackageListSize;
	    			}
	    			$listSize->package_id = $pid;
	    			$listSize->list_size = $listsize;
	    			$listSize->price = $data['price'][$lkey];
	    			$listSize->save();
	    		}
    		}
    		if(isset($data['features'])){
                PackageFeature::where(['package_id'=>$pid])->delete();
                foreach($data['features'] as $fkey=> $featureid){
                    $packfeature = new PackageFeature;
                    $packfeature->package_id = $pid;
                    $packfeature->feature_id = $featureid;
                    $packfeature->qty = $data['value'][$fkey];
                    $packfeature->save();
                }
    		}
    		return Redirect()->action([PackageController::class, 'packages'])->with('flash_message_success',$message);
    	}
    	return view('admin.packages.add-edit-package')->with(compact('title','packagedata','selFeatures'));
    }

    public function features(Request $Request){
        Session::put('active',5); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('features');
            if(!empty($data['name'])){
                $querys = $querys->where('name','like','%'.$data['name'].'%');
            }
            $querys = $querys->OrderBy('id','DESC');
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                    ->skip($iDisplayStart)->take($iDisplayLength)
                    ->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $feature){
                $checked='';
                if($feature['status']==1){
                    $checked='on';
                }else{
                    $checked='off';
                }
                $actionValues='<a title="Edit Feature" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-feature/'.$feature['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
                if($feature['parent_id'] !="ROOT"){
                	$parent = Feature::where('id',$feature['parent_id'])->first();
                	$feature['parent_id'] = $parent->name;
                }
                $num = ++$i;
                $records["data"][] = array(     
                    $num,
                    $feature['name'],
                    $feature['parent_id'],
                    '<div  id="'.$feature['id'].'" rel="features" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Features";
        return View::make('admin.packages.features')->with(compact('title'));
    }

    public function addEditFeature(Request $request,$fid=null){
    	$features = Feature::features();
    	if($fid==""){
    		$title="Add Feature";
    		$feature = new Feature;
    		$message ="Feature has been added successfully.";
    		$featuredata = array();
    	}else{
    		$title="Update Feature";
    		$feature = Feature::find($fid);
    		$message ="Feature has been updated successfully.";
    		$featuredata = json_decode(json_encode($feature),true);
    	}
    	if($request->isMethod('post')){
    		$data = $request->all();
    		//echo "<pre>"; print_r($data); die;
    		$feature->name =$data['name'];
            $feature->parent_id =$data['parent_id'];
    		$slug = strtolower($this->cleanstring($data['name']));
            $feature->slug =$slug;
            $feature->description =$data['description'];
    		$feature->status = 1;
    		$feature->save();
    		return Redirect()->action([PackageController::class, 'features'])->with('flash_message_success',$message);
    	}
    	return view('admin.packages.add-edit-feature')->with(compact('title','featuredata','features'));
    }

    public function updateDiscounts(Request $request){
    	Session::put('active',6);
    	$title="Update Discounts";
    	if($request->isMethod('post')){
    		$data =$request->all();
    		//echo "<pre>"; print_r($data); die;
    		if(isset($data['discounts'])){
    			foreach($data['discounts'] as $did => $discount){
    				$dis = Discount::find($did);
    				$dis->discount =$discount;
    				$dis->save();
    			}
    		}
    		return redirect()->back()->with('flash_message_success','Discounts has been updated successfully.');
    	}
    	$discounts = Discount::get();
    	$discounts = json_decode(json_encode($discounts),true);
    	return view('admin.packages.update-discounts')->with(compact('title','discounts'));
    }

    public function coupons(Request $Request){
        Session::put('active',7); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('coupon_codes');
            if(!empty($data['code'])){
                $querys = $querys->where('code','like','%'.$data['code'].'%');
            }
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                        ->skip($iDisplayStart)->take($iDisplayLength)
                        ->OrderBy('id','DESC')
                        ->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $coupon){ 
                $checked='';
                if($coupon['status']==1){
                    $checked='on';
                }
                else{
                    $checked='off';
                }
                $deletcoupon ='<a  title="Delete"  class="btn btn-sm red margin-top-10" rel="'.$coupon['id'].'"  onclick=" return ConfirmDelete()" href="'.url('admin/delete-coupon/'.$coupon['id']).'"> <i class="fa fa-times"></i></a>'; 
                $actionValues='
                    <a title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-coupon/'.$coupon['id']).'"> <i class="fa fa-edit"></i>
                    </a>';

                if($coupon['amount_type'] =="Percentage"){
                    $amount = $coupon['amount'] ."%";
                }else{
                    $amount =  "$".$coupon['amount'];
                }
                $num = ++$i;
                $records["data"][] = array(      
                    $num,
                    $coupon['code'],
                    $coupon['coupon_type'],
                    $amount,
                    date('d-F-Y',strtotime($coupon['expiry_date'])),
                    '<div  id="'.$coupon['id'].'" rel="coupon_codes" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues.$deletcoupon
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Coupons";
        return View::make('admin.packages.coupons')->with(compact('title'));
    }

    public function addEditCoupon(Request $request, $id=null){
        Session::put('active',7); 
        if($id !=""){
            $couponId = $id;
            $couponData = DB::table('coupon_codes')->where('id',$couponId)->first();
            $couponData = json_decode(json_encode($couponData),true);
            $title = "Edit Coupon";
            $coupon = CouponCode::find($couponId);
            $message= "Coupon updated successfully.!";
        }else{
            $couponData = array();
            $title = "Add Coupon";
            $coupon = new CouponCode;
            $message= "Coupon added successfully.!";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            unset($data['_token']);
            foreach($data as $key=> $value){
                if($key != "code"){
                    $coupon->$key =$value;
                }
            }
            if(empty($couponData)){
                if($data['codeoption'] =="Manual"){
                    if($data['code']==""){
                        $code = Str::random(6);
                        $checkCode = DB::table('coupon_codes')->where(['code'=>$code])->count();
                        while($checkCode>0){
                            $code = Str::random(6);
                            $checkCode = DB::table('coupon_codes')->where(['code'=>$code])->count();
                        }
                        $coupon->code = strtolower($code);
                    } else{
                        $coupon->code = strtolower($data['code']);
                    }
                }else{
                    $code = Str::random(6);
                    $checkCode = DB::table('coupon_codes')->where(['code'=>$code])->count();
                    while($checkCode>0)
                    {
                        $code = Str::random(6);
                        $checkCode = DB::table('coupon_codes')->where(['code'=>$code])->count();
                    }
                    $coupon->code = strtolower($code);
                }
            }
            if(isset($data['status'])){
                $coupon->status = 1;
            }else{
                $coupon->status = 0;
            }
            $coupon->save();
            return redirect()->action([PackageController::class, 'coupons'])->with('flash_message_success',$message);
        }
        return view('admin.packages.add-edit-coupon')->with(compact('title','couponData'));
    }

    public function checkCouponCode(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getcount = DB::table('coupon_codes')->where('code',$data['code'])->count();
            if($getcount == 0){
                echo '{"valid":true}';die;
            }else{
                echo '{"valid":false}';die;
            }
        }
    }

    public function deleteCouponCode($id){
        $CouponId = $id;
        $coupondetails = CouponCode::where('id',$id)->first();
        DB::table('coupon_codes')->where('id',$CouponId)->delete();
        return redirect()->action([PackageController::class, 'coupons'])->with('flash_message_success','Coupon '.$coupondetails->code.' has been deleted successfully.');
    }
}
