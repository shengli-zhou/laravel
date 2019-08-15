<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ShowController extends Controller
{
	public function goods(Request $request)
	{
		$arr = $request->all();
		$goods_id=$arr['gid'];
		$arr=Db::select("select goods.id as gid,goods.name as g_name,attrdetails.name as attrdetails_name,attrdetails.id as attrd_id,attribute.name as attr_name from goodsattr join goods on goodsattr.goods_id=goods.id join attrdetails on goodsattr.attr_details_id=attrdetails.id join attribute on goodsattr.attr_id=attribute.id where goods.id=$goods_id");
		$newarr=[];
		foreach ($arr as $key => $value) {
			// $newarr[$value->g_name][$value->attr_name][]=$value->attrdetails_name;
			// $newarr[$value->attr_name][]=[$value->attrdetails_name,$value->attrd_id];
			$newarr[$value->attr_name][]=[$value->attrdetails_name,$value->attrd_id];
		}

		$ass['g_name']=$arr[0]->g_name;
		$ass['data']=$newarr;
		// var_dump($ass);
		return response()->json($ass);
	}	
	public function findware(Request $request)
	{
		$arr=$request->input();
		// var_dump($arr);die;
		$attrd_id=$arr['attrd_id'];
		// var_dump($attrd_id);
		$gid=$arr['gid'];
		$attrd_id=substr($attrd_id,1);
		$attrd_id=str_replace('-', ',', $attrd_id);
		$attrd_id=explode(',', $attrd_id);
		sort($attrd_id);
		$length=count($attrd_id);
		$sort=[];
		for ($i=0; $i <$length ; $i++) { 
			 $sort[]=$attrd_id[$i];
   		 }
   		 $attrd_id=implode('-', $sort);
   		 // var_dump($attrd_id);die;
   		 $arr=DB::select("select * from goodsp where goods_id='$gid' and goods_attr_id='$attrd_id'");
   		 return response()->json($arr);
	}

}