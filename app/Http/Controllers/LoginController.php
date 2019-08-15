<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class LoginController extends Controller
{


    public function login()
    {
   
    }

     public function loginAction(Request $request)
    {
  	$name=$request->input('name');
  	$password=$request->input('password');
  	
     $arr = DB::select("select * from admin where name='$name' and password='$password'");
       if (empty($arr)) {
         $arr1=['code'=>'1','status'=>'error','data'=>'用户名或密码错误'];
         return json_encode($arr1);
       }else{
       	  $arr2=['code'=>'0','status'=>'ok','data'=>'登录成功'];
       	  Session::put("name",$name);
        // $request->session()->get($name);
          return json_encode($arr2);
       }
     
    }
    
    
     public function gfloor(){
      $arr=Db::select("select floor.id,floor.name as f_name,goods.id as goods_id,goods.name as g_name from floor join floorgoods on floor.id=floorgoods.f_id join goods on floorgoods.g_id=goods.id");
      // echo "<pre>";
      // var_dump($arr);
      $array=array();
      foreach ($arr as $k => $v) {
      $array[$v->f_name][]=[$v->g_name,$v->goods_id];
      
    }
    // var_dump($cc);
      return response()->json($array);
    }


     public function show()
    {
       $arr=Db::select("select * from goods");
       return response()->json($arr);

    }

    public function tree()
    {
      $arr=Db::select("select * from goods_category");
      $ayy=$this->cate_gory($arr,0,0);
      // var_dump($ayy);
      $js=['code'=>'200','status'=>'success','data'=>$ayy];
      return response()->json($ayy);
    }
    public function cate_gory($arr,$id,$level)
    {
        $list =array();
    foreach ($arr as $k=>$v){
        if ($v->pid == $id){
            $v->level=$level;
            $v->son = $this->cate_gory($arr,$v->id,$level+1);
            $list[] = $v;
        }
    }
    return $list;
}

    
     public function loginout(Request $request)
    {
     $request->session()->forget('name');
     
       return redirect('login');
 
    }
    
}