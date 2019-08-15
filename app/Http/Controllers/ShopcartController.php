<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Http\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
class ShopcartController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api',['except'=>[]]);
	}

	public function shopcart(Request $request)
	{
		$arr=$request->input();
		var_dump($arr);
		$num=$arr['num'];
		$wid=$arr['wid'];
		var_dump($wid);
		$name=$arr['name'];
		$price=$arr['price'];
		$attrd_id=$arr['attrd_id'];
		$uid=Db::select("select id from users where name='$name'");
		foreach ($uid as $key => $value) {
			$uid=$value->id;
		}
		$arr=Db::select("select * from shopcart where uid='$uid' and wid='$wid'");
		if ($arr) {
			foreach ($arr as $key => $value) {
				$number=$value->num;
			}
			$n=$num+$number;
			Db::update("update shopcart set num='$n' where uid='$uid' and wid='$wid'");
			$arr=Db::select("select * from shopcart where uid='$uid' and wid='$wid'");
		}else{
			$arr=Db::table('shopcart')->insert(['uid'=>$uid,'wid'=>$wid,'num'=>$num,'price'=>$price,'attrd_id'=>$attrd_id,]);
		}
			return response()->json($arr);
	}


	public function buycart()
    {
       $name=auth()->user();
       $uid=$name['id'];
       $arr=DB::select("select goodsp.goods_id,goodsp.price,shopcart.num,shopcart.attrd_id,goods.name as name,goodsp.id as goodsp_id,goodsp.goods_attr_name from shopcart join goodsp on shopcart.wid=goodsp.id join goods on goodsp.goods_id=goods.id where uid='$uid'");
        return response()->json($arr);
    }
      
     public function greed()
     {
     	  $num=request()->post('num');
     	  $goodsp_id=request()->post('goodsp_id');
          $name=auth()->user();
          $uid=$name['id'];
          DB::update("update shopcart set num='$num' where uid='$uid' and wid='$goodsp_id'");
          return response()->json($goodsp_id);
     }
}