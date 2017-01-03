<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Input;
use Validator;  // use for form validation
use Image;  // Use for image resize
use App\Product; // load product model
use App\ProductPrices; // load ProductPrices model
use App\Category;
use App\Brands;
use App\ProductImages;
class adminProducts extends Controller {
	public function __construct(){
    $this->middleware('Admin');
  }
	//========== :::: product-list :::: =========
	public function productList(){
		
		$data['products']=Product::paginate(2);
		$data['meta_title']="Admin | Product-List";
		$data['heading']="Product";
		$data['left_panel_parent']='productParent';
		$data['left_panel_sub']='productChild';
		return view('admin/products/product_list')->with('data',$data);
	}
	
	//======== :::: product-add ::::=============
	public function productAdd(Request $request){
		$data['heading']="Add Product";
		$data['category_list'] = Category::where([['parent_id','0'],['status','ACTIVE']])->orderBy('name','ASC')->pluck('name','id')->toArray();
		$data['brand_list'] =Brands::where('status','ACTIVE')->orderBy('name','ASC')->pluck('name','id')->toArray(); 
		if($request->all()){
			$validator = Validator::make($request->all(), Product::rules());
			if($validator->fails()){
				return redirect('/admin/product-list')->with('flash-error-list',$validator->errors()->all());
				
				if(url()->previous()){
					return redirect(url()->previous())->with('flash-error-list',$validator->errors()->all());
				}else{
					return redirect('/admin/product-list')-with('flash-error-list',$validator->errors()->all());
				}	
			}else{
				//===image upload===
				$originalPath=public_path('/uploads/images/');
				$largePath=public_path('/uploads/images/large/');
				$thumblPath=public_path('/uploads/images/thumb/');
				$imageName="";
				if($request->default_image!=null){
					$imageName = 'product_'.time().'.'.$request->default_image->getClientOriginalExtension();
					//=====Resize Large====
					$large_img = Image::make($request->default_image->getRealPath());
					$large_img->resize(100, 150, function ($constraint) {
						$constraint->aspectRatio();
					})->save($largePath.'/'.$imageName);
					//=====Resize Thumb ====
					$thumb_img = Image::make($request->default_image->getRealPath());
					$thumb_img->resize(78, 48, function ($constraint) {
						$constraint->aspectRatio();
					})->save($thumblPath.'/'.$imageName);
					//====Orginal Image=====
					$request->default_image->move($originalPath.'/',$imageName);
				}
				$save_data=[
					'name'=>$request->name,
					'code'=>$request->code,
					'default_image'=>$imageName,
					's_description'=>$request->short_description,
					'description'=>$request->long_description,
					'ord_position'=>'0',
					'is_featured'=>$request->is_featured,
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>NULL,
					'status'=>'ACTIVE'
				];
				$products=Product::create($save_data);
				if($products){
					$save_price=[
						'original_price'=>$request->price,
						'offer_percent'=>$request->discount_percent,
						'offer_start_date'=>$request->discount_start_date,
						'offer_end_date'=>$request->discount_end_date,
						'vat_percent'=>$request->vat_percent,
						'tax_percent'=>$request->tax_percent,
						'other_service_charge'=>$request->other_service_charge,
						'delevery_charge'=>$request->delevery_charge,
						'product_id'=>$products->id,
						'created_at'=>date('Y-m-d H:i:s'),
						'updated_at'=>NULL
					];
					$save_product_brand_map=[
						'brand_id'=>$request->brand,
						'product_id'=>$products->id
					];
					$save_product_category_map=[
						'cat_id'=>$request->category,
						'sub_cat_id'=>$request->sub_category,
						'product_id'=>$products->id
					];
					ProductPrices::create($save_price);
					DB::table('product_brand_maps')->insert($save_product_brand_map);
					DB::table('product_category_maps')->insert($save_product_brand_map);
					
					if(url()->previous()){
						return redirect(url()->previous())->with('flash-success','Record has been added successfully.');
					}else{
						return redirect('/admin/product-list')->with('flash-success','Record has been added successfully.');
					}
						
				}else{
					if(trim($imageName)!=""){
						@unlink($originalPath.'/'.$imageName);
						@unlink($largePath.'/'.$imageName);
						@unlink($thumblPath.'/'.$imageName);
					}
				}
			}	
		}
		return view('admin/products/product_add')->with('data',$data);
	}
	
	//======== :::: category-edit :::: =============
	public function productEdit(Request $request,$pid){
		$data['heading']="Edit Category";
		$data['category_list'] = Category::where([['status','ACTIVE'],['parent_id','0']])->orderBy('name','ASC')->pluck('name','id')->toArray(); 
		$data['brand_list'] =Brands::where('status','ACTIVE')->orderBy('name','ASC')->pluck('name','id')->toArray(); 
		try{
			$products=Product::with('productPrice','productBrandMap','productCategoryMap')->findOrFail($id);
			//$productPrice=ProductPrices::where('product_id',$id)->first();
			if($request->all()){
			$validator = Validator::make($request->all(),Product::rules($id));
			if($validator->fails()){
				if(url()->previous()){
					return redirect(url()->previous())->with('flash-error-list',$validator->errors()->all());
				}else{
					return redirect('/admin/product-list')->with('flash-error-list',$validator->errors()->all());
				}
				
			}else{
					//===image upload===
					$originalPath=public_path('/uploads/images/');
					$largePath=public_path('/uploads/images/large/');
					$thumblPath=public_path('/uploads/images/thumb/');
					$imageName="";
					$oldImageName=$products->image;
					if($request->default_image!=null){
						$imageName = 'category_'.time().'.'.$request->default_image->getClientOriginalExtension();
						$products->image=$imageName;
						//=====Resize Large====
						$large_img = Image::make($request->default_image->getRealPath());
						$large_img->resize(100, 150, function ($constraint) {
							$constraint->aspectRatio();
						})->save($largePath.'/'.$imageName);
						//=====Resize Thumb ====
						$thumb_img = Image::make($request->default_image->getRealPath());
						$thumb_img->resize(78, 48, function ($constraint) {
							$constraint->aspectRatio();
						})->save($thumblPath.'/'.$imageName);
						//====Orginal Image=====
						$request->default_image->move($originalPath.'/',$imageName);
					}
					//====Set product data =====
					$products->name=$request->name;
					$products->code=$request->code;
					$products->s_description=$request->short_description;
					$products->description=$request->long_description;
					$products->is_featured=$request->is_featured;
					$products->updated_at=date('Y-m-d H:i:s');
					
					//======Ser Product-Price Data ======
					$products->productPrice->original_price=$request->price;
					$products->productPrice->offer_percent=$request->discount_percent;
					$products->productPrice->offer_start_date=$request->discount_start_date;
					$products->productPrice->offer_end_date=$request->discount_end_date;
					$products->productPrice->vat_percent=$request->vat_percent;
					$products->productPrice->tax_percent=$request->tax_percent;
					$products->productPrice->other_service_charge=$request->other_service_charge;
					$products->productPrice->delevery_charge=$request->delevery_charge;
					$products->productPrice->updated_at=date('Y-m-d H:i:s');
					
					//========Product brand Map ===========
					$products->productBrandMap->brand_id=$request->brand;
					
					//========Product category Map ===========
					$products->productCategoryMap->cat_id=$request->category;
					$products->productCategoryMap->sub_cat_id=$request->sub_category;
					
					if($products->save()){
						$products->productPrice()->save($products->productPrice);
						$products->productBrandMap()->save($products->productBrandMap);
						$products->productCategoryMap()->save($products->productCategoryMap);
						if(trim($imageName)!=""){
							@unlink($originalPath.'/'.$oldImageName);
							@unlink($largePath.'/'.$oldImageName);
							@unlink($thumblPath.'/'.$oldImageName);
						}
						if(url()->previous()){
							return redirect(url()->previous())->with('flash-success','Record has been updated successfully.');
						}else{
							return redirect('/admin/product-list')->with('flash-success','Record has been updated successfully.');
						}
					}else{
						if(trim($imageName)!=""){
							@unlink($originalPath.'/'.$imageName);
							@unlink($largePath.'/'.$imageName);
							@unlink($thumblPath.'/'.$imageName);
						}
					}
				}	
			}
			$data['products']=$products;
			//$data['productPrice']=$productPrice;
		}
		catch(ModelNotFoundException $e){
			$data['exceptionError']="Invalid request Or internal server problem. Please try again later.";
		}
		return view('admin/products/product_edit')->with('data',$data);
	}
	//========== :::: Product Image Upload :::: ========
	public function productImageUpload(Request $request,$pid){
		$data['heading']="Product Image Upload";
		$data['p_id']=$pid;
		try{
			$data['product_images']=ProductImages::where('product_id',$pid)->get();
		}catch(ModelNotFoundException $e){
			$data['exceptionError']="Invalid request Or internal server problem. Please try again later.";
		}
		return view('admin/products/product_image_upload')->with('data',$data);
	}
	
	
	//======== :::: product-delete :::: ==============
	public function productDelete(Request $request,$id){ 
		$status='ERROR';
		$msg="Please try again later.";
		try{
			$products=Product::findOrFail($request->id);
			$products->status='DELETE';
			if($products->save()){
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
	
	//======== :::: product-Image-delete :::: ==============
	public function productImageDelete(Request $request,$id){ 
		$status='ERROR';
		$msg="Please try again later.";
		try{
			$products=Product::productImage()->findOrFail($request->id);
			$products->status='DELETE';
			if($products->save()){
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
	
	//======= :::: product-change-status :::: =========
	public function productChangeStatus(Request $request,$id){
		$status='ERROR';
		$msg="Please try again later.";
		$change_status="";
		try{
			$products=Product::findOrFail($request->id);
			$change_status=trim($products->status)=='ACTIVE' ? "INACTIVE" : "ACTIVE";
			$products->status=$change_status;
			if($products->save()){
				$status='SUCCESS';
				$msg="Record status has been changed successfully.";
			}else{
				$change_status=trim($products->status)=='INACTIVE' ? "ACTIVE" : "INACTIVE";
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
	//============::: is Category Name present :::================
	public function isProductCodeExists(Request $request,$id=null){
		$status=false;
		$msg="Please try again later.";
		$validator = Validator::make($request->all(), ['code'=>'required|min:3|max:60|unique:products,code' . ($id ? ",$id" : '')]);
		if($validator->fails()){
			$errors = $validator->errors();
			$msg=$errors->first('code');
			$status=false;
		}else{
			$status=true;
			$msg='success';
		}
		echo json_encode(array('status'=>$status,'msg'=>$msg));
		exit;
	}
	
	//=============drop zone product image upload ==========
		public function ajaxDropzoneProductImageUpload(Request $request,$pid = null){
			$status='ERROR';
			$image_id=0;
			$msg="Please try again later.";
			
			try{
				$Product=Product::where('id',$pid)->firstOrFail();
				//======Image path ==========
				$originalPath=public_path('/uploads/images/');
				$largePath=public_path('/uploads/images/large/');
				$thumblPath=public_path('/uploads/images/thumb/');
				
				$validator = Validator::make($request->all(), ['product_image'=>'required|image|mimes:jpeg,png,jpg|max:4096']);
				if($validator->fails()){
					$errors = $validator->errors();
					$msg=$errors->first('file');
					$status='ERROR';
				}else{
					$imageName="";
					if(Input::file('product_image')){
						$imageName = 'product_'.time().'.'.Input::file('product_image')->getClientOriginalExtension();
						//=====Resize Large====
						$large_img = Image::make(Input::file('product_image')->getRealPath());
						$large_img->resize(500, 600, function ($constraint) {
							$constraint->aspectRatio();
						})->save($largePath.'/'.$imageName);
						//=====Resize Thumb ====
						$thumb_img = Image::make(Input::file('product_image')->getRealPath());
						$thumb_img->resize(200, 180, function ($constraint) {
							$constraint->aspectRatio();
						})->save($thumblPath.'/'.$imageName);
						//====Orginal Image=====
						Input::file('product_image')->move($originalPath.'/',$imageName);
					}
					$save_data=[
						'image'=>$imageName,
						'product_id'=>$Product->id,
						'status'=>'ACTIVE'
					];
					if($rtn=ProductImages::create($save_data)){
						$image_id=$rtn->id;
						$status='SUCCESS';
						$msg="File has been uploaded successfully.";
					}else{
						if(trim($imageName)!=""){
							@unlink($originalPath.'/'.$imageName);
							@unlink($largePath.'/'.$imageName);
							@unlink($thumblPath.'/'.$imageName);
						}
						$image_id=0;
						$status='ERROR';
						$msg="Invalid request";
					}	
				}
			}catch (ModelNotFoundException $e) {
				$image_id=0;
				$status='ERROR';
				$msg="Invalid request";
			}
			echo json_encode(array("status"=>$status,"msg"=>$msg,'image_id'=>$image_id));
			exit;
    }
		//=============drop zone product image remove ==========
		public function ajaxDropzoneProductImageRemove($image_id = null){
			$status='ERROR';
			$msg="Please try again later.";
			try{
				$ProductImage=ProductImages::where('id',$image_id)->firstOrFail();
				if($ProductImage){
					$imageName=$ProductImage->image;
					//======Image path ==========
					$originalPath=public_path('/uploads/images/');
					$largePath=public_path('/uploads/images/large/');
					$thumblPath=public_path('/uploads/images/thumb/');
					if($ProductImage->delete()){
						@unlink($originalPath.'/'.$imageName);
						@unlink($largePath.'/'.$imageName);
						@unlink($thumblPath.'/'.$imageName);
						$status='SUCCESS';
						$msg="File has been remove successfully.";
					}
				}else{
					$status='ERROR';
					$msg="Invalid Request.";
				}
			}catch(ModelNotFoundException $e){
				$status='ERROR';
				$msg="Internal server problem.";
			}
			echo json_encode(array("status"=>$status,"msg"=>$msg));
			exit;
    }
		//======= :::: product image status change :::: ===============
		public function ajaxDropzoneProductImageChangeStatus($image_id=null){
			$status='ERROR';
			$msg="Please try again later.";
			$change_status="";
			try{
				$ProductImage=ProductImages::where('id',$image_id)->firstOrFail();
				if($ProductImage){
					$change_status=trim($ProductImage->status)=='ACTIVE' ? "INACTIVE" : "ACTIVE";
					$ProductImage->status=$change_status;
					if($ProductImage->save()){
						$status='SUCCESS';
						$msg="Record status has been changed successfully.";
					}
				}else{
					$status='ERROR';
					$msg="Invalid Request.";
					$change_status="";
				}
			}catch(ModelNotFoundException $e){
				$status='ERROR';
				$msg="Internal server problem.";
				$change_status="";
			}
			echo json_encode(array("status"=>$status,"msg"=>$msg,"change_status"=>$change_status));
			exit;
		}
}
