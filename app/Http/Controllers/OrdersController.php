<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use Session;
use App\Order;

class OrdersController extends Controller
{
    //
    public function orders(Request $Request){
        Session::put('active',10); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('orders')->join('users','users.id','=','orders.user_id')->select('orders.*','users.name as user_name');
            if(!empty($data['name'])){
                $querys = $querys->where('package_name','like','%'.$data['name'].'%');
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
            foreach($querys as $order){
                $actionValues='<a title="View Order Details" class="btn btn-sm blue margin-top-10" href="'.url('admin/order-details/'.$order['id']).'"> <i class="fa fa-file"></i>
                    </a>';
                $num = ++$i;
                $records["data"][] = array(     
                    $order['id'],
                    $order['invoice_id'],
                    $order['user_name'],
                    $order['package_name'],
                    $order['payment_mode'],  
                    $order['currency']. number_format($order['grand_total'],2),  
                    $order['payment_status'],  
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Orders";
        return View::make('admin.orders.orders')->with(compact('title'));
    }

    public function orderdetails($id){
    	$title="Order Details";
    	$orderdetails = Order::with('user')->where('id',$id)->first();
    	if($orderdetails){
	    	$orderdetails = json_decode(json_encode($orderdetails),true);
	    	return view('admin.orders.order-details')->with(compact('title','orderdetails'));
    	}else{
    		return redirect()->back();
    	}
    }
}
