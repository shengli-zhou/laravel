<?php

namespace App\Http\Controllers;

use Yansongda\Pay\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['return','notify']]);
    }

    protected $config = [
        'alipay' => [
            'app_id' => '2016101000650310',
            'notify_url' => 'http://localhost/blog/public/api/auth/notify',
            'return_url' => 'http://localhost/blog/public/api/auth/return',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnJKEP+B3RlehEd2fq5TnDMBJzfIQv67dkK8FSz4qobboufyMrgacfu8CWka6NSxp3uBmXQh2Ch9rZX/XpoDgRSCUThGMddBUfIDNrKUgrVMpWCtub6s1Vnc83YFB4oleO397jZzYzxoCBFFEPb2zQhQc5kZK1tbbjQHsaAI8Phc2eV+3sjalr5QSJl1MPdjqDn1UgC0T3qbsS6v4tWDzUVEy3uWRapMtFhpIPX3dhuxUwKQxtE9Zi/mYVkynBFJQvkjGrrWt2l7Ja2zPnffmYCcY4K/nLs1vviU6ntnrY7ZNDBwL6IngoG5rnMoMzynFI6A2o6c7Gb4EmkMrgJ5GwwIDAQAB',

            'private_key' => 'MIIEpAIBAAKCAQEA5G7hOLr52ubZqUBE45EnzvPiTVNO4JAaosw4WU9uMU/w9WZiZNQQ2g2MNjoanXMnYPZDp/1TsfsBLN01qd5cHMcsCzMuDvTDGnnAU5AxDHam0uJWyBX54+eVMrwJT3+a0akYNx5K4cUJbRDLm6sHPZuGX+TSNJXmeEDjWx8u8htgpS3poKMRAUz+aa9cpqamviVtAgS7f+NSsGyplTUOyIXWR8SXiAoaiSqCDS1AdaYhxfxu4beb4zWnPdi9NDl9bXAhp9B1+yjH42KmEjFGGuyyc+a3O6z5oFTL/FBWvrPFHt9b0v49GGJbsbg4Syuvj/xNyVADxAu3uvAscm8HFwIDAQABAoIBAQDdaqxb9MBicgjgiS889WIEs1jTYsC94nAvBIxJ5TgGDFqfQxJ0cSm0chVKKp/Jpeixj4Kcvmv1xDqrZe+yK5pVOqlyYbVvQcgrTYAif01Lq2agWkuLveFuCvcPKjxMFn/WYXTbWD11ASvVz8XLqcdm6+0f3gfyeKngPeUiWeODPzjXnXiWW+xQVvMdQ0v+tIGMz5Db16toz2tsqf3eH9XrXuJbxMVZrKaUhziqv9RWdiT1oMuuVOFtfbfJGNmowBU3DWOf7N8z7jYfnYU45fGhWb980+j0hx0Y8w6deoXCjvPz8w0WoNrG9R7P2DXQxFnXsjZVggkMQyDzE8LYEtuhAoGBAP44tXOJajAGorBy1lfi1C1vXyeRklOVqftUmFe/qm++3kpIxr+4YsCHJs14jKychcKUEVLMixl4UI+w4kryg55ZDPvSMcCNUnTf+Gma/Ou31kE7hzOSf/sdzTWYqPJzjvNbWHCFLzfUIlNb+F1tH7LhsrP1+qE314RfRsei/jdrAoGBAOYH/GbbrFnYVTW4FVFsTiUHEZe/8rUH0ygDpdoYWgDjftZQbspjuRUbUMDvxGIsbI6KP5KZhBLbvNHBm5E/sDzWHyzwIprsui/Q9g6Hw1OJ+Kpa1wD9wa1xVD9S1hP62QeXr1f6PD5IjfcREQctUNMXX3OGmfLcHAgyOw+/DlYFAoGATo0DNBHvp6tFNbQmGr3RxcA17KoERqNmBGydLe/hH+ogEV/vWWoFyWt5R9/Jx8QNaJQLzkO5b0NH0T5cjb/lf1YQtva5vL9uDQLvZOIo6ETDhSB5pCvOM69/quHiwheGwhcleo8MifmYKZ2vXl7LfqBScVy99naktxghbKomVsUCgYEArmGLdCY/5/RZ1Flyv8ENFIDhU1rOEXKXHpR1XHptcJMFik57Tq5+loOYmkqpY4st2HjxbJ84QluWLqVI27meTuA7zgNVGIExPCJ7BdThvCix++LVbwjvlB5/sWmIpKjbcigJYvZuSQETriKf+ALgbMYhNCDr//Hgxk3d/DfoFEkCgYA/LXBS3i6sMc4rmGMx7cc/un2bo+MjJ7x+O3vddJ+ewBkLh5dVkH0pu4UiZZlS4nkAQPDyr9it6hDlO7SDGD7Ll+dGNka9Z+ko0nJFJbmOez5PHJkfcUmTyGw1BOcCaYfL6leXOAhZN5KxtLlmqmV6jb165RL54F1IUJWQ78IY2Q==',
        ],
    ];

    public function index(Request $request)
    {
        $oid=$request->input('id');
        $arr=Db::select("select * from order_x where order_id=$oid");
        $sun=0;
        foreach ($arr as $key => $value) {
            $sum+=$value->price*$value->num;
        }
        $config_biz = [
            'out_trade_no' =>$request->input('id'),
            'total_amount' => $sum,
            'subject'      => 'test subject',
        ];

        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->pay($config_biz);
    }

    public function return(Request $request)
    {
        $pay = new Pay($this->config);
        $arr=$pay->driver('alipay')->gateway()->verify($request->all());
        $array=$arr['out_trade_no'];
        $array1=$arr['total_amount'];
        // return $pay->driver('alipay')->gateway()->verify($request->all());
        header("location:http://localhost:8080/#/Car_Three?order_id=$array&price=$array1");
    }

    public function notify(Request $request)
    {
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->all())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。 
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号； 
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）； 
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）； 
            // 4、验证app_id是否为该商户本身。 
            // 5、其它业务逻辑情况
            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}