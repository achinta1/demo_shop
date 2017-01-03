<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ProductBrandMaps extends Model{
	public $timestamps = false;
	protected $table = 'product_brand_maps';
	protected $guarded = ['id'];
	protected $fillable = ['brand_id','product_id'];
}
?>