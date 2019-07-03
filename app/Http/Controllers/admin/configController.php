<?php

namespace App\Http\Controllers\admin;

use App\Model\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class configController extends Controller
{
    private $config;
    public function __construct(Config $config)
    {
        $this->config=$config;
    }
    public function index(){
        $data = $this->config->oneInfo();
        return view('admin/config/index',['info'=>$data]);
    }
    public function insert(Request $request){
        $param = $request->all();
        if(!empty($param['id'])){
            $data = $this->config->edit($param);
            return $data? state(0,'编辑成功',$data):state(1,'编辑失败','');
        }else{
            $data = $this->config->add($param);
            return $data? state(2,'编辑成功',$data):state(1,'编辑失败','');
        }
    }
    /**
     * 配置
     */
    public function configapi(){
        $data=$this->config->oneinfo();
        return $data? state(0,'配置详情',$data):state(1,'无数据','');
    }


}
