<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder{
	public function run(){
		DB::table('brands')->delete();
		DB::table('categories')->delete();
		DB::table('migrations')->delete();
		DB::table('password_resets')->delete();
		DB::table('products')->delete();
		DB::table('product_brand_maps')->delete();
		DB::table('product_category_maps')->delete();
		DB::table('users')->delete();
		$this->command->info('Demo Shop Seed Finished.');
			
		DB::table('users')->insert([
		'user_name'=>'Admin',
		'name'=>'Site Admin',
		'email'=>'admin@gmail.com',
		'password'=>bcrypt('123456'),
		'type'=>'SA',
		'created_at'=>date('Y-m-d H:i:s'),
		'status'=>'ACTIVE'
		]);
		$this->command->info('The user=>> admin@gmail.com and pass=>> 123456!');
	}
}
