<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Auth::routes();
Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');


//===============Admin Routes (Start)=================
Route::group(['prefix' =>'admin'],function(){
	Route::get('/',['uses'=>'Admin@index']);
	Route::any('/login',['uses'=>'Admin@index']);
	Route::get('/dashboard',['uses'=>'Admin@dashboard']);
	Route::any('/profile',['uses'=>'Admin@profile']);
	Route::any('/change-password',['uses'=>'Admin@changePassword']);
	//Route::any('/site-settings',['uses'=>'Admin@siteSettings']);
	
	//=========== :::: brands ::::================
	Route::get('/brand-list',['uses'=>'adminBrands@brandList']);
	Route::post('/brand-add',['uses'=>'adminBrands@brandAdd']);
	Route::post('/brand-edit/{id}',['uses'=>'adminBrands@brandEdit'])->where('id', '[0-9]+');
	//========== :::: download excell :::: ========
	Route::get('/excel-download',['uses'=>'adminBrands@excelDownload']);
	//========== :::: download PDF :::: ========
	Route::get('/pdf-download',array('as'=>'pdf-download','uses'=>'adminBrands@pdfDownload'));
	//======== :::: category :::: ==============
	Route::get('/category-list',['uses'=>'adminCategories@categoryList']);
	Route::post('/category-add',['uses'=>'adminCategories@categoryAdd']);
	Route::post('/category-edit/{id}',['uses'=>'adminCategories@categoryEdit'])->where('id', '[0-9]+');
	
	//======== :::: sub-category :::: ==============
	Route::get('/sub-category-list',['uses'=>'adminCategories@subCategoryList']);
	Route::post('/sub-category-add',['uses'=>'adminCategories@subCategoryAdd']);
	Route::post('/sub-category-edit/{id}',['uses'=>'adminCategories@subCategoryEdit'])->where('id', '[0-9]+');
	
	//======= :::: product :::: ====================
	Route::get('/product-list',['uses'=>'adminProducts@productList']);
	Route::post('/product-add',['uses'=>'adminProducts@productAdd']);
	Route::post('/product-edit/{id}',['uses'=>'adminProducts@productEdit'])->where('id', '[0-9]+');
	
	Route::post('/ajax-dropzone-product-img-upload/{pid}',['uses'=>'adminProducts@ajaxDropzoneProductImageUpload'])->where('pid', '[0-9]+');
	Route::post('/ajax-dropzone-product-img-remove/{image_id?}',['uses'=>'adminProducts@ajaxDropzoneProductImageRemove'])->where('image_id','[0-9]+');
	Route::post('/ajax-dropzone-product-img-change-status/{image_id?}',['uses'=>'adminProducts@ajaxDropzoneProductImageChangeStatus'])->where('image_id','[0-9]+');
	
	
	//======== :::: AJAX CAll URL RESTRICET :::: ========
  if(Request::ajax()){
		//=========== :::: brands ::::================
		Route::get('/brand-add',['uses'=>'adminBrands@brandAdd']);
		Route::get('/brand-edit/{id}',['uses'=>'adminBrands@brandEdit'])->where('id', '[0-9]+');
		Route::post('/brand-delete/{id}',['uses'=>'adminBrands@brandDelete'])->where('id', '[0-9]+');
		Route::post('/brand-change-status/{id}',['uses'=>'adminBrands@brandChangeStatus'])->where('id', '[0-9]+');
		Route::post('/brandname-exists/{id?}',['uses'=>'adminBrands@isBrandNameExists'])->where('id', '[0-9]+');
		
		//========== :::: Users :::: =================== 
		Route::post('/users-email-exists/{id?}',['uses'=>'Admin@isUserEmailExists'])->where('id', '[0-9]+');
		
		//========== :::: category :::: ================
		Route::get('/category-add',['uses'=>'adminCategories@categoryAdd']);
		Route::get('/category-edit/{id}',['uses'=>'adminCategories@categoryEdit'])->where('id', '[0-9]+');
		Route::post('/category-delete/{id}',['uses'=>'adminCategories@categoryDelete'])->where('id', '[0-9]+');
		Route::post('/category-change-status/{id}',['uses'=>'adminCategories@categoryChangeStatus'])->where('id', '[0-9]+');
		Route::post('/categoryname-exists/{id?}',['uses'=>'adminCategories@isCategoryNameExists'])->where('id', '[0-9]+');
		Route::post('/sub-cat-list',['uses'=>'adminCategories@subCatList']);
		
		//======== :::: sub-category :::: ==============
		Route::get('/sub-category-add',['uses'=>'adminCategories@subCategoryAdd']);
		Route::get('/sub-category-edit/{id}',['uses'=>'adminCategories@subCategoryEdit'])->where('id', '[0-9]+');
		
		//======= :::: Products :::: ===================
		Route::get('/product-add',['uses'=>'adminProducts@productAdd']);
		Route::get('/product-edit/{id}',['uses'=>'adminProducts@productEdit'])->where('id', '[0-9]+');
		Route::post('/product-delete/{id}',['uses'=>'adminProducts@productDelete'])->where('id', '[0-9]+');
		Route::post('/product-change-status/{id}',['uses'=>'adminProducts@productChangeStatus'])->where('id', '[0-9]+');
		Route::post('/product-code-exists/{id?}',['uses'=>'adminProducts@isProductCodeExists'])->where('id', '[0-9]+');
		Route::get('/product-image-upload/{pid?}',['uses'=>'adminProducts@productImageUpload'])->where('pid', '[0-9]+');
		
		
		
  }

	
	
	Route::any('/logout',['uses'=>'Admin@doLogout']);
});




//===============Admin Routes (Start)=================



