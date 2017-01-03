<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model{
	protected $table = 'products';
	protected $guarded = ['id'];
	protected $fillable = ['name','code','default_image','s_description','description','ord_position','is_featured','created_at','updated_at','status'];
	//use SoftDeletes;
	//const CREATED_AT = 'creation_date';
  //const UPDATED_AT = 'last_update'
	public static function rules ($id=0, $merge=[]){
		return array_merge(
		[
			'name'=>'required|min:3|max:60',
			'code'=>'required|min:3|max:60|unique:products,code'.($id ? ",$id" : ''),
			'short_description'=>'required|max:200',
			'long_description'=>'required',
			'default_image'=> ($id ? " " : 'required|').'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		],
		$merge);
	}
	//====get product price =======
	public function productPrice(){
		return $this->hasOne('App\ProductPrices','product_id');
	}
	//====get product Images =======
	public function productImage(){
		return $this->hasmany('App\ProductImages','product_id');
	}
	
	//====get product brand map =======
	public function productBrandMap(){
		return $this->hasOne('App\ProductBrandMaps','product_id');
	}
	//====get product category map =======
	public function productCategoryMap(){
		return $this->hasOne('App\ProductCategoryMaps','product_id');
	}
	
	
	
}
?>