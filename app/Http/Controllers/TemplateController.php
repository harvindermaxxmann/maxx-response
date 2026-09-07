<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Category;
use App\Page;
use Image;
use App\Template;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class TemplateController extends Controller
{
    //
    public function categories(Request $Request){
        Session::put('active',8); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('categories');
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
            foreach($querys as $category){
                $checked='';
                if($category['status']==1){
                    $checked='on';
                }else{
                    $checked='off';
                }
                $actionValues='<a title="Edit Category" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-category/'.$category['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
                if($category['parent_id'] !="ROOT"){
                    $parent = Category::where('id',$category['parent_id'])->first();
                    $category['parent_id'] = $parent->name;
                }
                $num = ++$i;
                $records["data"][] = array(     
                    $num,
                    $category['name'],
                    $category['parent_id'],
                    '<div  id="'.$category['id'].'" rel="categories" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Template Type";
        return View::make('admin.templates.categories')->with(compact('title'));
    }

    public function addEditCategory(Request $request,$catid=null){
        $categories = Category::cats();
    	if($catid==""){
    		$title="Add Template Type";
    		$category = new Category;
    		$message ="Template Type  has been added successfully.";
    		$categorydata = array();
    	}else{
    		$title="Update Template Type";
    		$category = Category::find($catid);
    		$message ="Template Type has been updated successfully.";
    		$categorydata = json_decode(json_encode($category),true);
    	}
    	if($request->isMethod('post')){
    		$data = $request->all();
    		//echo "<pre>"; print_r($data); die;
            $category->name =$data['name'];
    		$category->parent_id =$data['parent_id'];
    		$category->description =$data['description'];
    		$category->status = 1;
    		$category->save();
    		return Redirect()->action([TemplateController::class, 'categories'])->with('flash_message_success',$message);
    	}
    	return view('admin.templates.add-edit-category')->with(compact('title','categorydata','categories'));
    }

    public function pages(Request $Request){
        Session::put('active',9); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = Page::with('feature');
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
            foreach($querys as $page){
                $checked='';
                if($page['status']==1){
                    $checked='on';
                }else{
                    $checked='off';
                }
                $actionValues='<a title="Edit Category" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-page/'.$page['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
               	$image = '<img  width="110" src='.asset('images/default.png').'>';
                if($page['image'] !=""){
               	 	$imagepath = public_path('images/PageImages/'.$page['image']);
                	if(file_exists($imagepath)){
                		$image = '<img  width="110" src='.asset('images/PageImages/'.$page['image']).'>';
                	}
                }
                $num = ++$i;
                $records["data"][] = array(     
                    $num,
                    $page['name'],
                    $page['feature']['name'],
                    $image,
                    '<div  id="'.$page['id'].'" rel="pages" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Template";
        return View::make('admin.templates.pages')->with(compact('title'));
    }

    public function addEditPage(Request $request,$pageid=null){
    	if($pageid==""){
    		$title="Add Template";
    		$page = new Page;
    		$message ="Template has been added successfully.";
    		$pagedata = array();
    	}else{
    		$title="Update Template";
    		$page = Page::find($pageid);
    		$message ="Template has been updated successfully.";
    		$pagedata = json_decode(json_encode($page),true);
    	}
    	if($request->isMethod('post')){
    		$data = $request->all();
    		$page->name =$data['name'];
            $page->feature_id = $data['feature_id'];
    		$page->template_id = $data['template_id'];
    		$page->type = "Landing Page";
    		$page->description =$data['description'];
            if(!$pagedata){
                $page->status = 1;
            }
    		if($request->hasFile('image')){
                if ($request->file('image')->isValid()) {
                    $file = $request->file('image');
                    $img = Image::make($file);
                    $destination = public_path('/images/PageImages/');
                    if(!empty($pagedata) &&  $pagedata['image'] !="" && file_exists($destination.$pagedata['image'])){
                        unlink($destination.$pagedata['image']);
                    }
                    $ext = $file->getClientOriginalExtension();
                    $mainFilename = "page-".time().Str::random(5).".".$ext;
                    $img->save($destination.$mainFilename);
                    $page->image= $mainFilename;
                }
            }
    		$page->save();
    		return Redirect()->action([TemplateController::class, 'pages'])->with('flash_message_success',$message);
    	}
        $templates = Template::where('status',1)->get();
    	return view('admin.templates.add-edit-page')->with(compact('title','pagedata','templates'));
    }
}
