<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
use Validator;  // use for form validation
use Image;  // Use for image resize
use Excel;  // Use to generate excel file
use PDF;		// Use to generate pdf file
class adminBrands extends Controller {
	public function __construct(){
    $this->middleware('Admin');
  }
	//========== :::: brand-list :::: =========
	public function brandList(){
		$data['brands']=DB::table('brands')->paginate(2);
		$data['meta_title']="Admin | Brand-List";
		$data['heading']="Brand";
		$data['left_panel_parent']='brandParent';
		$data['left_panel_sub']='brandChild';
		return view('admin/brands/brand_list')->with('data',$data);
	}
	//======== :::: brand-add ::::=============
	public function brandAdd(Request $request){
		$data['heading']="Add Brand";
		if($request->all()){
			$validator = Validator::make($request->all(), [
				'brand_name' => 'required|min:3|max:60|unique:brands,name|regex:/^[A-Za-z -]+$/',
				'order_position' => 'required|numeric|regex:/^[0-9]+$/',
				'brand_logo'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			]);
			if($validator->fails()){
				return redirect('/admin/brand-list')->with('flash-error-list',$validator->errors()->all());
			}else{
				//===image upload===
				$originalPath=public_path('/uploads/images/');
				$largePath=public_path('/uploads/images/large/');
				$thumblPath=public_path('/uploads/images/thumb/');
				$imageName="";
				if($request->brand_logo!=null){
					$imageName = 'brand_'.time().'.'.$request->brand_logo->getClientOriginalExtension();
					//=====Resize Large====
					$large_img = Image::make($request->brand_logo->getRealPath());
					$large_img->resize(100, 150, function ($constraint) {
						$constraint->aspectRatio();
					})->save($largePath.'/'.$imageName);
					//=====Resize Thumb ====
					$thumb_img = Image::make($request->brand_logo->getRealPath());
					$thumb_img->resize(78, 48, function ($constraint) {
						$constraint->aspectRatio();
					})->save($thumblPath.'/'.$imageName);
					//====Orginal Image=====
					$request->brand_logo->move($originalPath.'/',$imageName);
				}
				$save_data=[
				'name'=>$request->brand_name,
				'order_position'=>$request->order_position,
				'image'=>$imageName,
				'created_at'=>date('Y-m-d H:i:s'),
				'status'=>'ACTIVE'
				];
				//$brands=DB::table('brands')->insertGetId($save_data); // Get last insert id
				$brands=DB::table('brands')->insert($save_data);
				if($brands){
					return redirect('/admin/brand-list')->with('flash-success','Record has been added successfully.');
				}else{
					if(trim($imageName)!=""){
						@unlink($originalPath.'/'.$imageName);
						@unlink($largePath.'/'.$imageName);
						@unlink($thumblPath.'/'.$imageName);
					}
				}
			}	
		}
		return view('admin/brands/brand_add')->with('data',$data);
	}
	//======== :::: brand-edit :::: =============
	public function brandEdit(Request $request,$id){
		$data['heading']="Edit Brand";
		$brands=DB::table('brands')->select('*')->where('id',$id)->first();
		if($request->all()){
			$validator = Validator::make($request->all(), [
				'brand_name' => 'required|min:3|max:60|unique:brands,name,'.$brands->id.'|regex:/^[A-Za-z -]+$/',
				'order_position' => 'required|numeric|regex:/^[0-9]+$/',
				'brand_logo'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			]);
			if($validator->fails()){
				return redirect('/admin/brand-list')->with('flash-error-list',$validator->errors()->all());
			}else{
				//===image upload===
				$originalPath=public_path('/uploads/images/');
				$largePath=public_path('/uploads/images/large/');
				$thumblPath=public_path('/uploads/images/thumb/');
				$imageName="";
				$oldImageName=$brands->image;
				if($request->brand_logo!=null){
					$imageName = 'brand_'.time().'.'.$request->brand_logo->getClientOriginalExtension();
					$brands->image=$imageName;
					//=====Resize Large====
					$large_img = Image::make($request->brand_logo->getRealPath());
					$large_img->resize(100, 150, function ($constraint) {
						$constraint->aspectRatio();
					})->save($largePath.'/'.$imageName);
					//=====Resize Thumb ====
					$thumb_img = Image::make($request->brand_logo->getRealPath());
					$thumb_img->resize(78, 48, function ($constraint) {
						$constraint->aspectRatio();
					})->save($thumblPath.'/'.$imageName);
					//====Orginal Image=====
					$request->brand_logo->move($originalPath.'/',$imageName);
				}
								
				$brands->name=$request->brand_name;
				$brands->order_position=$request->order_position;
				$brands->updated_at=date('Y-m-d H:i:s');
				$update_brands=DB::table('brands')->where('id',$request->id)->update((array) $brands);
				if($update_brands){
					if(trim($imageName)!=""){
						@unlink($originalPath.'/'.$oldImageName);
						@unlink($largePath.'/'.$oldImageName);
						@unlink($thumblPath.'/'.$oldImageName);
					}
					return redirect('/admin/brand-list')->with('flash-success','Record has been updated successfully.');
				}else{
					if(trim($imageName)!=""){
						@unlink($originalPath.'/'.$imageName);
						@unlink($largePath.'/'.$imageName);
						@unlink($thumblPath.'/'.$imageName);
					}
				}
			}	
		}
		$data['brands']=$brands;
		return view('admin/brands/brand_edit')->with('data',$data);
	}
	//======== :::: brand-delete :::: ==============
	public function brandDelete(Request $request,$id){ 
		$status='ERROR';
		$msg="Please try again later.";
		$brands=DB::table('brands')->select('*')->where('id',$request->id)->first();
		if($brands){
			$brands->status='DELETE';
			$update_brands=DB::table('brands')->where('id',$request->id)->update((array) $brands);
			if($update_brands){
				$status='SUCCESS';
				$msg="Record has been deleted successfully.";
			}else{
				$status='ERROR';
				$msg="Please try again later.";
			}
		}
		echo json_encode(array("status"=>$status,"msg"=>$msg));
		exit;
	}
	//======= :::: brand-change-status :::: =========
	public function brandChangeStatus(Request $request,$id){
		$status='ERROR';
		$msg="Please try again later.";
		$change_status="";
		$brands=DB::table('brands')->select('*')->where('id',$request->id)->first();
		if($brands){
			$change_status=trim($brands->status)=='ACTIVE' ? "INACTIVE" : "ACTIVE";
			$brands->status=$change_status;
			$update_brands=DB::table('brands')->where('id',$request->id)->update((array) $brands);
			if($update_brands){
				$status='SUCCESS';
				$msg="Record status has been changed successfully.";
			}else{
				$change_status=trim($Brand->status)=='INACTIVE' ? "ACTIVE" : "INACTIVE";
				$status='ERROR';
				$msg="Please try again later.";
			}
		}
		echo json_encode(array("status"=>$status,"msg"=>$msg,"change_status"=>$change_status));
		exit;
	}
	//============::: is Brand Name present :::================
	public function isBrandNameExists(Request $request,$id=null){
		$status=false;
		$msg="Please try again later.";
		if(trim($id)!="" && $id!=null && $id>0){
			$validator = Validator::make($request->all(), ['brand_name' => 'required|min:3|max:60|unique:brands,name,'.$id.'|regex:/^[A-Za-z -]+$/']);
		}else{
			$validator = Validator::make($request->all(), [
			'brand_name' => 'required|min:3|max:60|unique:brands,name|regex:/^[A-Za-z -]+$/',
			]);
		}
		if($validator->fails()){
			$errors = $validator->errors();
			$msg=$errors->first('brand_name');
			$status=false;
		}else{
			$status=true;
			$msg='success';
		}
		echo json_encode(array('status'=>$status,'msg'=>$msg));
		exit;
	}
	
	//========= :::: Generate Excel file :::: ========
	public function excelDownload(){
		$payments=DB::table('brands')->get();
		// Initialize the array which will be passed into the Excel
    // generator.
    $paymentsArray = []; 
    // Define the Excel spreadsheet headers
    $paymentsArray[] = ['id', 'name','image','order_position','created_at','updated_at','status'];
    // Convert each member of the returned collection into an array,
    // and append it to the payments array.
    foreach ($payments as $payment) {
      $paymentsArray[] = (array) $payment;
    }
		// Generate and return the spreadsheet
    Excel::create('Brand-List', function($excel) use ($paymentsArray) {
      // Set the spreadsheet title, creator, and description
      $excel->setTitle('Brand List');
      $excel->setCreator('Laravel')->setCompany('Test Demo Company');
      $excel->setDescription('Brand list file');
      // Build the spreadsheet, passing in the payments array
      $excel->sheet('sheet1', function($sheet) use ($paymentsArray) {
        $sheet->fromArray($paymentsArray, null, 'A1', false, false);
      });
    })->download('xlsx');
	}
	//========= :::: generate pdf :::: ===========
	public function pdfDownload(Request $request){
		$brands = DB::table("brands")->get();
		view()->share('brands',$brands);
		if($request->has('download')){
			$pdf = PDF::loadView('admin/brands/brand_pdf');
      return $pdf->download('brand-list.pdf');
		}
		return view('admin/brands/brand_pdf');
		
		//========= To View on browser ============
		//$filename = 'test.pdf';
		//$path = storage_path($filename);
		//return Response::make(file_get_contents($path), 200, ['Content-Type' => 'application/pdf','Content-Disposition' => 'inline; filename="'.$filename.'"']);
	}
	
}
