<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Notice;

class noticeController extends Controller
{
    private $notice;
    public function __construct(Notice $notice)
    {
        $this->notice=$notice;
    }
    /**
     * 首页
     */
    public function index(Request $request){
        $param=$request->all();
        if(!empty($param['type'])){
            if($param['type']=='add'){
                return view('admin/notice/notice_insert');
            }else if($param['type']=='edit'){
                $notice=$this->notice->info($param['id']);
                return view('admin/notice/notice_update',['info'=>$notice]);
            }
        }
        return view('admin/notice/index');
    }
    /**
     * 主页数据
     */
    public function lists(Request $request){
        $param=$request->all();
        $data=$this->notice->lists($param);
        return $data?state('0','消息列表',$data['data'],$data['count']):state('0','无数据','');
    }
    /**
     * 添加通知
     */
    public function add(Request $request){
       $param=$request->all();
       $data=$this->notice->add($param);
       return $data?state('0','添加成功',$data):state('0','添加失败','');
    }
    /**
     * 修改通知
     */
    public function edit(Request $request,$id){
        $param=$request->all();
        $data=$this->notice->edit($param,$id);
        return $data?state('0','修改成功',$data):state('0','修改失败','');
    }
    /**
     * 删除通知
     */
    public function delete($id){
        $data=$this->notice->del($id);
        return $data?state('0','删除成功',$data):state('0','删除失败','');
    }
    /**
     * 通知接口
     */
    public function notice(){
        $data = $this->notice->allData();
        return $data?state(0,'全部通知',$data):state(1,'无数据','');
    }
}
