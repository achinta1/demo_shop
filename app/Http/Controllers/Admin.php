<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Image;
class Admin extends Controller {
	public function __construct(){
    //$this->middleware('Admin');
  }
	//========== :::: Login :::: =========
	public function index(Request $request){
		$data['meta_title']="Admin | Login";
		if (Auth::check()){
			$data['meta_title']="Admin | Dashboard";
			return redirect('/admin/dashboard')->with('data',$data);
		}
		if($request->all()){
		 $validator = Validator::make($request->all(), [
				'email' => 'required|email',
				'password' => 'required',
			]);//->validate(); //reditect auto
			if($validator->fails()){
				//return redirect('admin/login')->withErrors($validator)->withInput(); //auto validation
				// return with custm validation
				return redirect('admin/login')
				->withErrors([
					'email'=>'This field is required.',
					'password'=>'This field is required.'
				])
				->withInput();
			}
			if (Auth::attempt(['email' => $request->email, 'password' =>$request->password,'type'=>'SA'])){
				return redirect('/admin/dashboard')->with('data',$data);
			}else{
				$data['error_message']="Invalid email or password.";
			}
		}
		return view('admin/Login')->with('data',$data);
	}
	//========== :::: Dashboard :::: =========
	public function dashboard(){
		$data['meta_title']="Admin | Login";
		if (!Auth::check()){
			return redirect('/admin')->with('data',$data);
		}else{
			$data['meta_title']="Admin | Dashboard";
			$data['left_panel_parent']='dashboard';
			return view('admin/Dashboard')->with('data',$data);
		}
	}
	//========== :::: Admin Profile ::::======= 
	public function profile(Request $request){
		$data['meta_title']="Admin | MyProfile";
		$data['heading']="My Profile";
		if (!Auth::check()){
			return redirect('/admin');
		}else{
			$flash_msg_key="";
			$flash_msg="";
			$users=DB::table('users')->select('id','name','email','phone','about','default_image')->where('id',Auth::user()->id)->first();
			$data['users']=$users;
			if($request->all()){
				$users->name=$request->name;
				$users->email=$request->email;
				$users->phone=$request->phone;
				$users->about=$request->about;
				$validator = Validator::make($request->all(), [
					'name' => 'required|min:3|max:160|regex:/^[a-z-.]+( [a-z-.]+)*$/i',
					//'email' => 'required|email|unique:users',
					'email'=> 'required|email|unique:users,email,'.$users->id,
					'phone'=>'required|min:10|numeric|regex:/^[0-9]*$/i',
					'default_image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
				])->validate(); //reditect auto
				//===image upload===
				
				$originalPath=public_path('/uploads/images/');
				$largePath=public_path('/uploads/images/large/');
				$thumblPath=public_path('/uploads/images/thumb/');
				$old_file_name="";
				if($request->default_image!=null){
					$old_file_name=$users->default_image;
					$imageName = 'profile_'.time().'.'.$request->default_image->getClientOriginalExtension();
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
					$users->default_image=$imageName;
				}
				$update=DB::table('users')->where('id',Auth::user()->id)->update((array) $users);
				if($update){
					if(trim($old_file_name)!=""){
						@unlink($originalPath.'/'.$old_file_name);
						@unlink($largePath.'/'.$old_file_name);
						@unlink($thumblPath.'/'.$old_file_name);
					}
					$data['users']=$users;
					$flash_msg_key="flash-success";
					$flash_msg="Record has been updated successfully.";
				}else{
					$flash_msg_key="flash-error";
					$flash_msg="Nothing change for update.";
				}
				return redirect('/admin/profile')->with($flash_msg_key,$flash_msg);
			}
			return view('admin/Profile')->with('data',$data);
		}
	}
	//========== :::: Logout :::: =========
	public function doLogout(){
		Auth::logout();
		return redirect('/admin');
		exit;
	}
	
	//============::: is user email exists :::============================
	public function isUserEmailExists(Request $request,$id=null){
		$status=false;
		$msg="Please try again later.";
		if(trim($id)!="" && $id!=null && $id>0){
			$validator = Validator::make($request->all(), [
			'email' => 'required|email|unique:users,email,'.$id
			]);
		}else{
			$validator = Validator::make($request->all(), [
			'email' => 'required|email|unique:users,email'
			]);
		}
		if($validator->fails()){
			$errors = $validator->errors();
			$msg=$errors->first('email');
			$status=false;
		}else{
			$status=true;
			$msg='success';
		}
		echo json_encode(array('status'=>$status,'msg'=>$msg));
		exit;
	}
	
	
	
	
	
	
	
	
	
	
	//################################################
	//================================================
	public function doLogin(Request $request){
		if($request->all()){
			//dd($request->all());
			//Remember me
			//if (Auth::attempt(['email' => $email, 'password' => $password], //$remember)){
				
			//}
			//Check is remember me
			//if (Auth::viaRemember()){
				
			//}
			//Login by Auth token
			//if (Auth::attempt(['email' => $request->email, 'password' =>$request->password,'type'=>'SA'])){
			//	return redirect()->intended('dashboard');
			//}
			//Custm auth generate
			//Auth::login($user);// store data in to auth
			//if (Auth::check()) // check the is auth 
			//Auth::logout(); // Logout
			
			//$data = DB::table('users')->where([['email','=',$request->email],['type','=','SA'],['status','=','ACTIVE']])->first();
			
					//use Illuminate\Validation\Rule;
					//Validator::make($data, ['email' => ['required',
						//Rule::exists('staff')->where(function ($query) {
							//$query->where('account_id', 1);
							//}),
						//],
					//]);
					
					
					
				//$validator = Validator::make($request->all(), [
				//'name' => 'required|min:3|max:160|regex:/^[a-z-.]+( [a-z-.]+)*$/i',
				//'email' => 'required|email|unique:users',
				//'phone'=>'required|min:10|max:15|numeric|regex:/(01)[0-9]{9}/',
				//'default_image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			//])->validate(); //reditect auto
			
			// Delete a single file
			//File::delete($filename);
			// Delete multiple files
			//File::delete($file1, $file2, $file3);
		}
	}
}
