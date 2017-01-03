<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
use Input;
use Validator;  // use for form validation
use Image;  // Use for image resize
use App\Category; // load category model
class adminCategories extends Controller {
	public function __construct(){
    $this->middleware('Admin');
  }
	//========== :::: category-list :::: =========
	public function categoryList(){
		//$Category = new Category();
		$data['categories']=Category::paginate(2);
		$data['meta_title']="Admin | Category-List";
		$data['heading']="Category";
		$data['left_panel_parent']='categoryParent';
		$data['left_panel_sub']='categoryChild';
		return view('admin/categories/category_list')->with('data',$data);
	}
	//======== :::: category-add ::::=============
	public function categoryAdd(Request $request){
		$data['heading']="Add Category";
		if($request->all()){
			$validator = Validator::make($request->all(), Category::rules());
			if($validator->fails()){
				return redirect('/admin/category-list')->with('flash-error-list',$validator->errors()->all());
			}else{
				//===image upload===
				$originalPath=public_path('/uploads/images/');
				$largePath=public_path('/uploads/images/large/');
				$thumblPath=public_path('/uploads/images/thumb/');
				$imageName="";
				if($request->category_logo!=null){
					$imageName = 'category_'.time().'.'.$request->category_logo->getClientOriginalExtension();
					//=====Resize Large====
					$large_img = Image::make($request->category_logo->getRealPath());
					$large_img->resize(100, 150, function ($constraint) {
						$constraint->aspectRatio();
					})->save($largePath.'/'.$imageName);
					//=====Resize Thumb ====
					$thumb_img = Image::make($request->category_logo->getRealPath());
					$thumb_img->resize(78, 48, function ($constraint) {
						$constraint->aspectRatio();
					})->save($thumblPath.'/'.$imageName);
					//====Orginal Image=====
					$request->category_logo->move($originalPath.'/',$imageName);
				}
				$save_data=[
				'name'=>$request->name,
				'image'=>$imageName,
				'parent_id'=>'0',
				'created_at'=>date('Y-m-d H:i:s'),
				'status'=>'ACTIVE'
				];
				$brands=Category::create($save_data);
				if($brands){
					return redirect('/admin/category-list')->with('flash-success','Record has been added successfully.');
				}else{
					if(trim($imageName)!=""){
						@unlink($originalPath.'/'.$imageName);
						@unlink($largePath.'/'.$imageName);
						@unlink($thumblPath.'/'.$imageName);
					}
				}
			}	
		}
		return view('admin/categories/category_add')->with('data',$data);
	}
	//======== :::: category-edit :::: =============
	public function categoryEdit(Request $request,$id){
		$data['heading']="Edit Category";
		//firstOrFail();
		//findOrFail();
		try{
			$categories=Category::findOrFail($id);
			if($request->all()){
			$validator = Validator::make($request->all(),Category::rules($id));
			if($validator->fails()){
				return redirect('/admin/category-list')->with('flash-error-list',$validator->errors()->all());
			}else{
					//===image upload===
					$originalPath=public_path('/uploads/images/');
					$largePath=public_path('/uploads/images/large/');
					$thumblPath=public_path('/uploads/images/thumb/');
					$imageName="";
					$oldImageName=$categories->image;
					if($request->category_logo!=null){
						$imageName = 'category_'.time().'.'.$request->category_logo->getClientOriginalExtension();
						$categories->image=$imageName;
						//=====Resize Large====
						$large_img = Image::make($request->category_logo->getRealPath());
						$large_img->resize(100, 150, function ($constraint) {
							$constraint->aspectRatio();
						})->save($largePath.'/'.$imageName);
						//=====Resize Thumb ====
						$thumb_img = Image::make($request->category_logo->getRealPath());
						$thumb_img->resize(78, 48, function ($constraint) {
							$constraint->aspectRatio();
						})->save($thumblPath.'/'.$imageName);
						//====Orginal Image=====
						$request->category_logo->move($originalPath.'/',$imageName);
					}
					$categories->name=$request->name;
					$categories->updated_at=date('Y-m-d H:i:s');
					if($categories->save()){
						if(trim($imageName)!=""){
							@unlink($originalPath.'/'.$oldImageName);
							@unlink($largePath.'/'.$oldImageName);
							@unlink($thumblPath.'/'.$oldImageName);
						}
						return redirect('/admin/category-list')->with('flash-success','Record has been updated successfully.');
					}else{
						if(trim($imageName)!=""){
							@unlink($originalPath.'/'.$imageName);
							@unlink($largePath.'/'.$imageName);
							@unlink($thumblPath.'/'.$imageName);
						}
					}
				}	
			}
			$data['categories']=$categories;
		}
		catch(ModelNotFoundException $e){
			$data['exceptionError']="Invalid request Or internal server problem. Please try again later.";
		}
		return view('admin/categories/category_edit')->with('data',$data);
	}
	//======== :::: category-delete :::: ==============
	public function categoryDelete(Request $request,$id){ 
		$status='ERROR';
		$msg="Please try again later.";
		try{
			$categories=Category::findOrFail($request->id);
			$categories->status='DELETE';
			if($categories->save()){
				$status='SUCCESS';
				$msg="Record has been deleted successfully.";
			}
		}catch(ModelNotFoundException $e){
			$status='ERROR';
			$msg="Invalid Request.";
		}
		echo json_encode(array("status"=>$status,"msg"=>$msg));
		exit;
	}
	//======= :::: category-change-status :::: =========
	public function categoryChangeStatus(Request $request,$id){
		$status='ERROR';
		$msg="Please try again later.";
		$change_status="";
		try{
			$categories=Category::findOrFail($request->id);
			$change_status=trim($categories->status)=='ACTIVE' ? "INACTIVE" : "ACTIVE";
			$categories->status=$change_status;
			if($categories->save()){
				$status='SUCCESS';
				$msg="Record status has been changed successfully.";
			}else{
				$change_status=trim($categories->status)=='INACTIVE' ? "ACTIVE" : "INACTIVE";
				$status='ERROR';
				$msg="Please try again later.";
			}
		}catch(ModelNotFoundException $e){
			$status='ERROR';
			$msg="Please try again later.";
			$change_status="";
		}
		echo json_encode(array("status"=>$status,"msg"=>$msg,"change_status"=>$change_status));
		exit;
	}
	
	//========== :::: sub-category-list :::: =========
	public function subCategoryList(){
		//$Category = new Category();
		$data['categories']= Category::where('parent_id','!=','0')->paginate(2);
		$data['meta_title']="Admin | Sub-Category-List";
		$data['heading']="Sub Category";
		$data['left_panel_parent']='categoryParent';
		$data['left_panel_sub']='subCategoryChild';
		return view('admin/categories/sub_category_list')->with('data',$data);
	}
	//======== :::: sub-category-add ::::=============
	public function subCategoryAdd(Request $request){
		$data['heading']="Add Sub Category";
		$data['category_list'] = Category::where([['status','ACTIVE'],['parent_id','0']])->orderBy('name','ASC')->pluck('name','id')->toArray();  
		// work with collection <5.3 version
		//$roles = Category::orderBy('name','ASC')->lists('name','id');
		if($request->all()){
			$validator = Validator::make($request->all(), Category::subcatrules());
			if($validator->fails()){
				return redirect('/admin/sub-category-list')->with('flash-error-list',$validator->errors()->all());
			}else{
				//===image upload===
				$originalPath=public_path('/uploads/images/');
				$largePath=public_path('/uploads/images/large/');
				$thumblPath=public_path('/uploads/images/thumb/');
				$imageName="";
				if($request->sub_category_logo!=null){
					$imageName = 'sub_category_'.time().'.'.$request->sub_category_logo->getClientOriginalExtension();
					//=====Resize Large====
					$large_img = Image::make($request->sub_category_logo->getRealPath());
					$large_img->resize(100, 150, function ($constraint) {
						$constraint->aspectRatio();
					})->save($largePath.'/'.$imageName);
					//=====Resize Thumb ====
					$thumb_img = Image::make($request->sub_category_logo->getRealPath());
					$thumb_img->resize(78, 48, function ($constraint) {
						$constraint->aspectRatio();
					})->save($thumblPath.'/'.$imageName);
					//====Orginal Image=====
					$request->sub_category_logo->move($originalPath.'/',$imageName);
				}
				$save_data=[
				'name'=>$request->name,
				'image'=>$imageName,
				'parent_id'=>$request->category,
				'created_at'=>date('Y-m-d H:i:s'),
				'status'=>'ACTIVE'
				];
				$brands=Category::create($save_data);
				if($brands){
					return redirect('/admin/sub-category-list')->with('flash-success','Record has been added successfully.');
				}else{
					if(trim($imageName)!=""){
						@unlink($originalPath.'/'.$imageName);
						@unlink($largePath.'/'.$imageName);
						@unlink($thumblPath.'/'.$imageName);
					}
				}
			}	
		}
		return view('admin/categories/sub_category_add')->with('data',$data);
	}
	//======== :::: sub-category-edit :::: =============
	public function subCategoryEdit(Request $request,$id){
		$data['heading']="Edit Sub Category";
		$data['category_list'] = Category::where([['status','ACTIVE'],['parent_id','0']])->orderBy('name','ASC')->pluck('name','id')->toArray(); 
		try{
			$categories=Category::findOrFail($id);
			if($request->all()){
			$validator = Validator::make($request->all(),Category::subcatrules($id));
			if($validator->fails()){
				return redirect('/admin/sub-category-list')->with('flash-error-list',$validator->errors()->all());
			}else{
					//===image upload===
					$originalPath=public_path('/uploads/images/');
					$largePath=public_path('/uploads/images/large/');
					$thumblPath=public_path('/uploads/images/thumb/');
					$imageName="";
					$oldImageName=$categories->image;
					if($request->sub_category_logo!=null){
						$imageName = 'category_'.time().'.'.$request->sub_category_logo->getClientOriginalExtension();
						$categories->image=$imageName;
						//=====Resize Large====
						$large_img = Image::make($request->sub_category_logo->getRealPath());
						$large_img->resize(100, 150, function ($constraint) {
							$constraint->aspectRatio();
						})->save($largePath.'/'.$imageName);
						//=====Resize Thumb ====
						$thumb_img = Image::make($request->sub_category_logo->getRealPath());
						$thumb_img->resize(78, 48, function ($constraint) {
							$constraint->aspectRatio();
						})->save($thumblPath.'/'.$imageName);
						//====Orginal Image=====
						$request->sub_category_logo->move($originalPath.'/',$imageName);
					}
					$categories->name=$request->name;
					$categories->parent_id=$request->category;
					$categories->updated_at=date('Y-m-d H:i:s');
					if($categories->save()){
						if(trim($imageName)!=""){
							@unlink($originalPath.'/'.$oldImageName);
							@unlink($largePath.'/'.$oldImageName);
							@unlink($thumblPath.'/'.$oldImageName);
						}
						return redirect('/admin/sub-category-list')->with('flash-success','Record has been updated successfully.');
					}else{
						if(trim($imageName)!=""){
							@unlink($originalPath.'/'.$imageName);
							@unlink($largePath.'/'.$imageName);
							@unlink($thumblPath.'/'.$imageName);
						}
					}
				}	
			}
			$data['categories']=$categories;
		}
		catch(ModelNotFoundException $e){
			$data['exceptionError']="Invalid request Or internal server problem. Please try again later.";
		}
		return view('admin/categories/sub_category_edit')->with('data',$data);
	}
	
	//============::: is Category Name present :::================
	public function isCategoryNameExists(Request $request,$id=null){
		$status=false;
		$msg="Please try again later.";
		$validator = Validator::make($request->all(), ['name'=>'required|min:3|max:60|unique:categories,name' . ($id ? ",$id" : '')]);
		if($validator->fails()){
			$errors = $validator->errors();
			$msg=$errors->first('name');
			$status=false;
		}else{
			$status=true;
			$msg='success';
		}
		echo json_encode(array('status'=>$status,'msg'=>$msg));
		exit;
	}
	//============:::  get sub category list ajax :::================
	public function subCatList(Request $request){
		$status=false;
		$sub_cat_list=[];
		try{
			if(Input::get('id')){
				$sub_cat_list = Category::where([['parent_id',Input::get('id')],['status','ACTIVE']])->pluck('name','id')->toArray();
				$status=true;
			}
		}catch(ModelNotFoundException $e){
			$sub_cat_list=[];
			$status=true;
		}
		echo json_encode(array('status'=>$status,'axajdata'=>$sub_cat_list,'a'=>['parent_id'=>Input::get('id')]));
		exit;
	}
}
