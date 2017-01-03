<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ProductImages extends Model{
	public $timestamps = false;
	protected $table = 'product_images';
	protected $guarded = ['id'];
	protected $fillable = ['image','product_id'];
}
?>