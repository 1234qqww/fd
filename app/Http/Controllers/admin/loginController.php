<?php

namespace App\Http\Controllers\admin;

use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Expressorder;
class loginController extends Controller
{
    private $admin;
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }
    /**
     * 登录页面
     */
    public function login(){
        return view('admin/login/login');
    }
    /**
     * 检测登录
     */
    public function logincheck(Request $request){
        $param = $request->all();
        $data = $this->admin->check($param);
        return $data;
    }
    /**
     * 退出登录
     */
    public  function loginout(){
        session(['admin_id'=>'']);
        session(['admin_user'=>'']);
        return state(1,'退出','');
    }


}
