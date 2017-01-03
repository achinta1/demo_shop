<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProductBrandMapsTable extends Migration{
	public function up(){
		Schema::create('product_brand_maps', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('brand_id', 10)->default(0);
			$table->integer('product_id	', 10)->default(0);
		});
	}
	public function down(){
		Schema::drop('product_brand_maps');
	}
}
