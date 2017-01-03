<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateBrandsTable extends Migration{
	public function up(){
		Schema::create('brands', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 70)->index()->nullable();
			$table->string('image', 255)->index()->nullable();
			$table->tinyInteger('order_position', 1)->default(0);
			$table->dateTime('created_date')->nullable();
			$table->dateTime('updated_at')->nullable();
			$table->enum('status',['ACTIVE','INACTIVE','DELETE'])->default('INACTIVE');
		});
	}
	public function down(){
		Schema::drop('brands');
	}
}
