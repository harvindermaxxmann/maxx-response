<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\BillingDetail;
use App\Order;
use App\Feature;
use App\Page;
use App\Contact;
use App\LinkedList;
use Carbon\Carbon;
use Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class DashboardController extends Controller
{
    //
    public function dashboard(){
        Session::put('menuactive','dashboard');
        $title="Dashboard";
        $features = Feature::getfeatures();
        $currentplan = Order::where('order_status','Active')->where('user_id',Auth::user()->id)->orderBy('id','DESC')->first();
        $expirystring ="";
        if($currentplan && $currentplan->payment_mode=="free"){
            $date = Carbon::parse($currentplan->expiry_date);
            $now = Carbon::now();
            $days = $date->diffInDays($now);
            if($days >0){
                $expirystring = "Your trial period will expire in ". $days ." days.";
            }
        }
        return view('front.customers.dashboard')->with(compact('title','features','currentplan','expirystring')); 
    }

    public function myaccount(){
        Session::put('menuactive','my-account');
        $title="My Account";
        $states = array();
        $cities = array();
        $billingDetails = User::where('id',Auth::user()->id)->first();
        $billingDetails = json_decode(json_encode($billingDetails),true);
        if(!empty($billingDetails) && !empty($billingDetails['country'])){
            $countryid = DB::table('countries')->where('country_name',$billingDetails['country'])->select('id')->first();
            $states = DB::table('states')->where('country_id',$countryid->id)->get();
            $stateid = DB::table('states')->where('state_name',$billingDetails['state'])->first();
            $cities = DB::table('cities')->where('state_id',$stateid->id)->get();
        }
        $countries = DB::table('countries')->where('status',1)->get();
        return view('front.customers.my-account')->with(compact('title','billingDetails','countries','states','cities'));
    }

    public function updateAccountDetails(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'name' => 'bail|required|string|max:255|regex:/^[\pL\s\-]+$/u',
                'email' => 'bail|required|email|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i|max:255|unique:users,email,'.Auth::user()->id,
                'country' => 'bail|required',
                'state' => 'bail|required',
                'city' => 'bail|required',
                'address' => 'bail|required',
                'zip' => 'bail|required',
                'company_name' => 'bail|required|string|max:255',
                'phone' => 'bail|required|numeric|min:10',
            ];
            $emailerror = $data['email']. " email already registered with Maxx Response. Please choose another one.";
            $customMessages = [
                'email.unique' => $emailerror,
                'phone.min' => "Phone number must be atleast 10 digits"
            ];
            //$this->validate($request, $rules, $customMessages);
            $validator = Validator::make($data,$rules,$customMessages);
            if($validator->fails()) {
                return redirect::to('/my-account')->withErrors($validator);
            }
            $updateuser = User::find(Auth::user()->id);
            $updateuser->name = $data['name'];
            $updateuser->email = $data['email'];
            $updateuser->company_name = $data['company_name'];
            $updateuser->phone = $data['phone'];
            $updateuser->website = $data['website'];
            $updateuser->industry = $data['industry'];
            $updateuser->no_of_employees = $data['no_of_employees'];
            $updateuser->company_name = $data['company_name'];
            $updateuser->country = $data['country'];
            $updateuser->state = $data['state'];
            $updateuser->city = $data['city'];
            $updateuser->zip = $data['zip'];
            $updateuser->address = $data['address'];
            $updateuser->save();
            return redirect()->back()->with('flash_message_success','Account information has been updated successfully');
        }
    }

    public function changePassword(Request $request){   
        if($request->isMethod('post')){
            $data = $request->all();
            $rules  =  array(
                'current_password' => 'required',
                'password' => 'required|confirmed|min:6',
            );
            $validator = Validator::make($data,$rules);
            if($validator->fails()) {
                return redirect::to('/my-account?tab=change-password')->withErrors($validator);
            }
            if (Hash::check($data['current_password'], Auth::user()->password)) {
                User::where('id',Auth::user()->id)->update(['password'=>bcrypt($data['password'])]);
                return redirect::to('/my-account?tab=change-password')->with('flash_message_success','Your password has been updated successfully');
            }else{
                return redirect::to('/my-account?tab=change-password')->with('flash_message_error','Your current password is incorrect.');
            }
        }
    }

    public function viewinvoice($orderid){
        $orderDetails = Order::where('id',$orderid)->where('user_id',Auth::user()->id)->first();
        $orderDetails = json_decode(json_encode($orderDetails),true);
        if($orderDetails){
            $title="View Invoice";
            return view('front.customers.order-invoice')->with(compact('title','orderDetails'));
        }else{
            return redirect::to('/');
        }
    }

    
    
    public function createpage(Request $request,$slug){
        $currentplan = Order::where('order_status','Active')->where('user_id',Auth::user()->id)->orderBy('id','DESC')->count();
        if($currentplan){
            $title="Coming Soon";
            $availableSlugs = Feature::select('slug')->where('parent_id','ROOT')->get();
            $availableSlugs = Arr::flatten(json_decode(json_encode($availableSlugs),true));
            if(in_array($slug, $availableSlugs)){
                if($slug=="landing-page"){
                    $title="Landing Page";
                    $featureids = Feature::featureids($slug);
                    $templates = Page::where('status',1)->wherein('feature_id',$featureids);
                    if($request->isMethod('get')){
                        $data =$request->all();
                        if(!empty($data)){
                            if(isset($data['q'])){
                                $templates = $templates->where('name','like','%'.$data['q'].'%');
                            }
                            if(isset($data['template']) && !empty($data['template'])){
                                if($data['template'] !="all-templates"){
                                    $id = DB::table('features')->where('slug',$data['template'])->select('id')->first();
                                    if($id){
                                        $templates = $templates->where('feature_id',$id->id);
                                    }
                                }
                            }
                            if(isset($data['sort'])){
                                if($data['sort'] =="date"){
                                    $templates = $templates->orderby('created_at','DESC');
                                }elseif($data['sort'] =="asc"){
                                    $templates = $templates->orderby('name','asc');
                                }elseif($data['sort'] =="desc"){
                                    $templates = $templates->orderby('name','desc');
                                }
                            }else{
                                $templates = $templates->orderby('id','desc');
                            }
                        }
                    }
                    $templates = $templates->paginate(50);
                    if($request->ajax()){
                        return response()->json([
                            'view' => (String)View::make('layouts.frontLayout.landing-layout')->with(compact('templates'))
                        ]);
                    }else{
                        return view('front.landing-pages.create-landing-page')->with(compact('title','slug','templates')); 
                    }
                }else{
                    $title="Coming Soon";
                    $view ="front.pages.coming-soon";
                    return view('front.landing-pages.coming-soon')->with(compact('title','slug'));
                }
            }else{
                abort(404);
            }
        }else{
            return redirect::to('/pricing');
        }
    }

    public function contactlists(){
        Session::put('menuactive','contacts');
        $contactlists = LinkedList::withCount('contacts')->where('user_id',Auth::user()->id);
        if(isset($_GET['date']) && !empty($_GET['date'])) {
            $contactlists = $contactlists->whereDate('created_at',$_GET['date']);
        }

        $contactlists = $contactlists->get();
        $title="Contact List";
        return view('front.customers.contact-lists')->with(compact('title','contactlists'));
    }

    public function contacts(){
        Session::put('menuactive','contacts');
        $usercontacts = Contact::with('listname');
        if(isset($_GET['lists']) && !empty($_GET['lists'])){
            $linkedlists = explode(',',$_GET['lists']);
            $usercontacts = $usercontacts->wherein('linked_list_id',$linkedlists);
        }
        $usercontacts = $usercontacts->where('user_id',Auth::user()->id)->orderby('id','DESC')->paginate(100);
        $title = "Contacts";
        return view('front.customers.contacts')->with(compact('title','usercontacts')); 
    }

    public function addcontact(Request $request,$type){
        $availabaleContacts = array('single', 'contacts', 'multiple', 'import');
        if(in_array($type,$availabaleContacts)){
            if($request->isMethod('post')){
                $data = $request->all();
                if($type=="single"){
                    $rules = [
                        'email' => 'bail|required|email|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i|string|max:255',
                        'list_id' => 'bail|required',
                        'name' => 'bail|required|string|regex:/^[\pL\s\-]+$/u',
                        'country' => 'bail|string|regex:/^[\pL\s\-]+$/u',
                        'state' => 'bail|string|regex:/^[\pL\s\-]+$/u',
                        'city' => 'bail|string|regex:/^[\pL\s\-]+$/u',
                        'pincode' => 'bail|numeric',
                        'phone' => 'bail|required|numeric|digits:10',
                    ];
                    $customMessages = [
                        'list_id.required' =>'Please Select List Name',
                    ];
                    $this->validate($request, $rules, $customMessages);
                    $exists = Contact::where('email',$data['email'])->where('user_id',Auth::user()->id)->first();
                    if($exists){
                        $contact = Contact::find($exists->id);
                    }else{
                        $contact = new Contact;
                    }
                    $contact->user_id = Auth::user()->id;
                    $contact->linked_list_id = $data['list_id'];
                    $contact->email = $data['email'];
                    $contact->company_name = $data['company_name'];
                    $contact->name = $data['name'];
                    $contact->phone = $data['phone'];
                    $contact->job_title = $data['job_title'];
                    $contact->country = $data['country'];
                    $contact->state = $data['state'];
                    $contact->city = $data['city'];
                    $contact->pincode = $data['pincode'];
                    $contact->opt_in = $data['opt_in'];
                    $contact->save();

                  
                    return redirect()->action([DashboardController::class, 'contacts'])->with('flash_message_success','Contact has been added successfully');
                
                }
                // contact ///
                elseif($type=="contacts"){  

                   
                    $validator = Validator::make($request->all(), [
                        'name' => 'required',
                    ]);
                    if ($validator->passes()) { 
                        $check = DB::table('linked_lists')->where(['user_id'=>Auth::user()->id,'list_name'=>$data['name']])->count();
                        if($check ==0){
                            $listname = new LinkedList;
                            $listname->user_id = Auth::user()->id;
                            $listname->list_name = $data['name'];
                            $listname->save();
                            $listid = $listname->id;
                            
                        }else{
                            return redirect()->action([DashboardController::class, 'contacts'])->with('flash_message_error','This list name already exists.');
                            //return response()->json(['status'=>'failed','message'=>'This list name already exists.']);
                        }
                    }

                    $user_count = DB::connection('mysql2')->table('talent');
                    $user_count->where('service_id', $request->serviceType);
                    if(!empty($request->user_skills))
                    $user_count->Where('skills_set', 'like', '%' . $request->user_skills . '%');
                    $results = $user_count->get();

                    if(!empty($results)){
                        foreach ($results as $key => $result){
                            
                            $contact = new Contact;                        
                            $contact->user_id = Auth::user()->id;
                            $contact->linked_list_id = $listid;
                            $contact->email = $result->email_id;
                            $contact->company_name = '';
                            $contact->name = $result->candidate_name;
                            $contact->phone = $result->contact_number;
                            $contact->country = $result->country; 
                            $contact->state = $result->state;
                            $contact->city = $result->city;                       
                            $contact->save();
                        }
                    }                    

                    return redirect()->action([DashboardController::class, 'contacts'])->with('flash_message_success','Contact has been added successfully');
        
                }elseif($type=="multiple"){
                    $rules = [
                        'rows' => 'bail|required',
                        'list_id' => 'bail|required',
                        'email' => 'bail|required|array|min:1',
                        'email.*' => "required|email|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i|min:1",
                        'name' => 'bail|required|array|min:1',
                        'name.*' => "required|string|regex:/^[\pL\s\-]+$/u|max:255|min:1",
                        'phone' => 'bail|required|array|min:1',
                        'phone.*' => "required|numeric|digits:10",
                    ];
                    $customMessages = [];
                    foreach ($request->get('email') as $key => $val) {
                        $customMessages['email.' . $key . '.regex'] = 'The '.$val .' is not a valid email.';
                    }
                    foreach ($request->get('name') as $key => $val) {
                        $customMessages['name.' . $key . '.regex'] = 'The '.$val .' is not a valid  Name.';
                    }
                    $validator = Validator::make($data,$rules,$customMessages);
                    if($validator->fails()) {
                        return redirect::to('/add-contact/multiple?rows='.$data['rows'])->withInput($request->input())->withErrors($validator);
                    }
                    foreach ($data['email'] as $key => $email){
                        $exists = Contact::where('email',$email)->where('user_id',Auth::user()->id)->first();
                        if($exists){
                            $contact = Contact::find($exists->id);
                        }else{
                            $contact = new Contact;
                        }
                        $contact->user_id = Auth::user()->id;
                        $contact->linked_list_id = $data['list_id'];
                        $contact->email = $email;
                        $contact->company_name = $data['company_name'][$key];
                        $contact->name = $data['name'][$key];
                        $contact->phone = $data['phone'][$key];
                        $contact->country = $data['country'][$key];
                        $contact->state = $data['state'][$key];
                        $contact->city = $data['city'][$key];
                        $contact->pincode = $data['pincode'][$key];
                        $contact->job_title = $data['job_title'][$key];
                        $contact->opt_in = $data['opt_in'][$key];
                        $contact->save();
                    }
                    return redirect()->action([DashboardController::class, 'contacts'])->with('flash_message_success','Contact has been added successfully');
                }elseif($type=="import"){
                    $rules = [
                        'contact' => 'bail|required|mimes:csv,txt',
                        'list_id' => 'bail|required',
                    ];
                    $customMessages = [
                        'contact.required' =>'Please upload file',
                        'contact.mimes' =>'Please upload csv files only',
                        'list_id.required' =>'Please Select List Name',
                    ];
                    $this->validate($request, $rules, $customMessages);
                    $file = $request->filefile('contact');
                    $handle = fopen($file,"r");
                    $header = fgetcsv($handle, 0, ',');
                    //echo "<pre>"; print_r($header);
                    //$countheader= count($header); 
                    if(in_array('name',$header) && in_array('email',$header)  && in_array('phone',$header) && in_array('address',$header) ){
                            $file_name = $file->getClientOriginalName();
                            $file->move('files',$file_name);
                            $results = FacadesExcel::load('files/'.$file_name)->get();
                            $countrows = $results->count();
                            $contacts = json_decode(json_encode($results),true);
                            //echo "<pre>"; print_r($data); die;
                            if($countrows <=500){
                                foreach($contacts as $contactdetail){
                                    if(!empty($contactdetail['email']) && filter_var($contactdetail['email'], FILTER_VALIDATE_EMAIL)){
                                        $exists = Contact::where('email',$contactdetail['email'])->where('linked_list_id',$data['list_id'])->where('user_id',Auth::user()->id)->first();
                                        if($exists){
                                            $contact = Contact::find($exists->id);
                                        }else{
                                            $contact = new Contact;
                                        }
                                        $contact->user_id = Auth::user()->id;
                                        $contact->linked_list_id = $data['list_id'];
                                        $contactArray = array('email','name','phone','company_name','address','job_title','country','state','city','opt_in','pincode');
                                        foreach($contactArray  as $contactArr){
                                            if(isset($contactdetail[$contactArr]) && !empty($contactdetail[$contactArr])){
                                                if($contactArr =="phone"){
                                                    $contact->$contactArr = sprintf($contactdetail[$contactArr]);
                                                }else{
                                                    $contact->$contactArr = $contactdetail[$contactArr];
                                                }
                                            }
                                        }
                                        $contact->save();
                                    }
                                }
                                return redirect()->action([DashboardController::class, 'contacts'])->with('flash_message_success', 'Contacts has been imported successfully');
                            }else{
                                return redirect()->action([DashboardController::class, 'contacts'])->with('flash_message_error', 'You have added more than 500 rows in csv. Please add 500 or less.');
                            }
                    }else{
                        return redirect()->back()->with('flash_message_error', 'Your CSV files having unmatched Columns to our database...Your columns must be in this sequence <strong> name,email,address,phone</strong> only');
                    }
                }
            }
            $title ="Add Contacts";
            $countries = DB::table('countries')->where('status',1)->get();
            $lists = LinkedList::withCount('contacts')->get();        
            return view('front.customers.add-contact')->with(compact('title','type','countries', 'lists'));
        }else{  
            return redirect()->action([DashboardController::class, 'contacts'])->with('flash_message_error','Something went wrong');
        }
    }

    public function getspecservice(Request $request){ 
        $user_count = DB::connection('mysql2')->table('talent');
        $user_count->where('service_id', $request->service_id);

        if(!empty($request->skills))
            $user_count->Where('skills_set', 'like', '%' . $request->skills . '%');


        $result = $user_count->get()->count();

        return response()->json(['data'=>$result ]);

    }

   public function viewUserContcat(Request $request, $contactid){
        if($request->ajax()){
            $contactdetails = Contact::with('listname')->where('id',$contactid)->first();
            $contactdetails = json_decode(json_encode($contactdetails),true);
            $response = '<table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td><b>List Name</b></td>
                                    <td>'.$contactdetails['listname']['list_name'].'</td>
                                </tr>
                                <tr>
                                    <td><b>Name</b></td>
                                    <td>'.$contactdetails['name'].'</td>
                                </tr>
                                <tr>
                                    <td><b>Email</b></td>
                                    <td>'.$contactdetails['email'].'</td>
                                </tr>
                                <tr>
                                    <td><b>Phone</b></td>
                                    <td>'.$contactdetails['phone'].'</td>
                                </tr>
                                <tr>
                                    <td><b>Address</b></td>
                                    <td>'.$contactdetails['address'].'</td>
                                </tr>
                                <tr>
                                    <td><b>Country</b></td>
                                    <td>'.$contactdetails['country'].'</td>
                                </tr>
                                <tr>
                                    <td><b>State</b></td>
                                    <td>'.$contactdetails['state'].'</td>
                                </tr>
                                <tr>
                                    <td><b>City</b></td>
                                    <td>'.$contactdetails['city'].'</td>
                                </tr>
                                <tr>
                                    <td><b>Pincode</b></td>
                                    <td>'.$contactdetails['pincode'].'</td>
                                </tr>
                                <tr>
                                    <td><b>Job Title</b></td>
                                    <td>'.$contactdetails['job_title'].'</td>
                                </tr>
                                <tr>
                                    <td><b>OPT in</b></td>
                                    <td>'.(!empty($contactdetails['opt_in']) ? $contactdetails['opt_in'] : 'Not Available').'</td>
                                </tr>
                                <tr>
                                    <td><b>Company Name</b></td>
                                    <td>'.$contactdetails['company_name'].'</td>
                                </tr>
                            </tbody>
                          </table>';
            return $response;
        }
    }

    public function exportContacts(){
        $headers = array(
            'Content-Type'        => 'text/csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=Contact List.csv',
            'Expires'             => '0',
            'Pragma'              => 'public',
        );

        $response = new StreamedResponse(function(){
            // Open output stream
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, ["List Name","Name","Email","Phone","Address","Country","State","City","Pincode","Job Title","OPT In","Company Name"]);
            $exportcontacts  = Contact::with('listname')->where('user_id',Auth::user()->id);
            $exportcontacts = $exportcontacts->chunk(500, function($contacts) use($handle) {
                foreach ($contacts as $contact) {   
                    fputcsv($handle, [
                        $contact->listname->list_name,
                        $contact->name,
                        $contact->email,
                        $contact->phone,
                        $contact->address,
                        $contact->country,
                        $contact->state,
                        $contact->city,
                        $contact->pincode,
                        $contact->job_title,
                        $contact->opt_in,
                        $contact->company_name
                    ]);
                }
            });
            fclose($handle);
        },200, $headers);
        return $response->send();
    }

    public function deleteContact($contactid){
        Contact::where('id',$contactid)->where('user_id',Auth::user()->id)->delete();
        return redirect()->action([DashboardController::class, 'contacts'])->with('flash_message_success','Contact has been deleted successfully');
    }

    public function deleteContactlist($usercontacts){
        if($usercontacts){
        Contact::where('linked_list_id', $usercontacts)->where('user_id',Auth::user()->id)->delete();
        LinkedList::where('id',$usercontacts)->where('user_id',Auth::user()->id)->delete();
            }
       return redirect('/contact-lists')->with('flash_message_success','Contact has been deleted successfully');
    }


    public function addListName(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'list_name' => 'required|max:100',
            ]);
            if ($validator->passes()) {
                $check = DB::table('linked_lists')->where(['user_id'=>Auth::user()->id,'list_name'=>$data['list_name']])->count();
                if($check ==0){
                    $listname = new LinkedList;
                    $listname->user_id = Auth::user()->id;
                    $listname->list_name = $data['list_name'];
                    $listname->save();
                    $listid = DB::getPdo()->lastInsertId();
                    return response()->json(['status'=>'success','message'=>'','listid'=>$listid,'listname'=>$data['list_name']]);
                }else{
                    return response()->json(['status'=>'failed','message'=>'This list name already exists.']);
                }
            }
            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }


    public function logout(){
        Auth::logout();
        return redirect()->action([IndexController::class, 'login'])->with('flash_message_success','Logged out successfully');
    }
}
