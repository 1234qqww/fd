<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Banner;

class
bannerController extends Controller
{
    private $banner;
    public function __construct(Banner $banner)
    {
        $this->banner=$banner;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * banner图
     */
    public function index(){
        $data=$this->banner->oneinfo();
        if(!empty($data)){
            $data=$data->toArray();
        }
        if(!isset($data['indexbanner'])){
            $data['indexbanner']='';
        }else{
            $dat=explode(',', $data['indexbanner']);
            $data['indexbanner']=$dat;
        }
        if(!isset($data['ownerbanner'])){
            $data['ownerbanner']='';
        }else{
            $dat=explode(',', $data['ownerbanner']);
            $data['ownerbanner']=$dat;
        }
        if(!isset($data['id'])){
            $data['id']='';
        }
        return view('admin/banner/index',['info'=>$data]);
    }
    /**
     * 修改banner图
     */
    public function insert(Request $request){
        $param = $request->all();
        if(!empty($param['id'])){
            $data = $this->banner->edit($param);
            return $data? state(0,'编辑成功',$data):state(1,'编辑失败','');
        }else{
            $data = $this->banner->add($param);
            return $data? state(2,'添加成功',$data):state(1,'添加失败','');
        }

    }
    /**
     * banner图
     */
    public function banner(){
        $data = $this->banner->oneinfo();
        if(!empty( $data->indexbanner)){
            $data->indexbanner=explode(',', $data->indexbanner);
        }
        if(!empty( $data->indexbanner)){
            $data->ownerbanner=explode(',', $data->ownerbanner);
        }
        return $data?state(0,'全部通知',$data):state(1,'无数据','');
    }


}
