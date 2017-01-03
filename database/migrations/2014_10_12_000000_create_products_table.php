<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProductsTable extends Migration{
	public function up(){
		Schema::create('products', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 70)->index()->nullable();
			$table->string('image', 255)->index()->nullable();
			$table->string('s_description', 255)->nullable();
			$table->tinyInteger('ord_position', 1)->default(0);
			$table->enum('is_featured',['Y','N'])->default('N');
			$table->dateTime('created_date')->nullable();
			$table->dateTime('updated_at')->nullable();
			$table->enum('status',['ACTIVE','INACTIVE','DELETE'])->default('INACTIVE');
		});
	}
	public function down(){
		Schema::drop('products');
	}
}
