<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Brands extends Model{
	protected $table = 'brands';
	protected $guarded = ['id'];
	protected $fillable = ['name','image','order_position','status','created_at','updated_at'];
	public static function rules ($id=0, $merge=[]){
		return array_merge(
		[
			'name'=>'required|min:3|max:60|unique:brands,name' . ($id ? ",$id" : '')
		],
		$merge);
	}
}
?>