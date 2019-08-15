<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class Common extends Controller
{
	public function __construct(Request $request)
          {
          	$this->request=request();
          	//验证是否登录
          $this->middleware(function($request, $next) {
            if (!\Session::get('name')) {
            	return redirect('login');
            	die;
            }
           
            return $next($request);
        });
      }
}