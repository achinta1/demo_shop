<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCategoriesTable extends Migration{
	public function up(){
		Schema::create('categories', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 70)->index()->nullable();
			$table->string('image', 255)->index()->nullable();
			$table->dateTime('created_date')->nullable();
			$table->dateTime('updated_at')->nullable();
			$table->enum('status',['ACTIVE','INACTIVE','DELETE'])->default('ACTIVE');
		});
	}
	public function down(){
		Schema::drop('categories');
	}
}
