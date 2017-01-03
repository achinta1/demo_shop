<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model{
	protected $table = 'categories';
	protected $guarded = ['id'];
	protected $fillable = ['name','image','status','parent_id'];
	//use SoftDeletes;
	//const CREATED_AT = 'creation_date';
  //const UPDATED_AT = 'last_update'
	public static function rules ($id=0, $merge=[]){
		return array_merge(
		[
			'name'=>'required|min:3|max:60|unique:categories,name' . ($id ? ",$id" : ''),
			'category_logo'=> ($id ? " " : 'required|').'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		],
		$merge);
	}
	public static function subcatrules ($id=0, $merge=[]){
		return array_merge(
		[
			'name'=>'required|min:3|max:60|unique:categories,name' . ($id ? ",$id" : ''),
			'sub_category_logo'=> ($id ? " " : 'required|').'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		],
		$merge);
	}
	//====get parent category for sub category =======
	public function parentcaregory(){
		return $this->belongsTo('App\Category','parent_id');
	}
}
?>