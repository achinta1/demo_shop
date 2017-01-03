<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ProductPrices extends Model{
	protected $table = 'product_prices';
	protected $guarded = ['id'];
	protected $fillable = ['original_price','offer_percent','offer_start_date','offer_end_date','vat_percent','tax_percent','other_service_charge','delevery_charge','product_id'];
}
?>