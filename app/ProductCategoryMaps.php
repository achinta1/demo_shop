<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ProductCategoryMaps extends Model{
	public $timestamps = false;
	protected $table = 'product_category_maps';
	protected $guarded = ['id'];
	protected $fillable = ['cat_id','sub_cat_id','product_id'];
}
?>