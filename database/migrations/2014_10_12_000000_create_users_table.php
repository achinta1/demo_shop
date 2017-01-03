<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUsersTable extends Migration{
	public function up(){
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('user_name',70)->index()->nullable();
			$table->string('name', 70)->index()->nullable();
			$table->string('email', 190)->unique()->nullable();
			$table->string('password', 255)->nullable();
			$table->string('phone', 13)->nullable();
			$table->string('default_image', 255)->nullable();
			$table->text('about')->nullable();
			$table->enum('type', ['SA','U'])->default('U');
			$table->dateTime('created_at')->nullable();
			$table->dateTime('updated_at')->nullable();
			$table->string('remember_token', 255)->nullable();
			$table->enum('status',['ACTIVE','INACTIVE','DELETE'])->default('INACTIVE');
		});
	}
	public function down(){
		Schema::drop('users');
	}
}
