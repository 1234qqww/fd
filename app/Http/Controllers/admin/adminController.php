<?php

namespace App\Http\Controllers\admin;

use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class adminController extends Controller
{
    private $admin;
    public function __construct(Admin $admin)
    {
        $this->admin=$admin;
    }
    public function index(Request $request){
        $param=$request->all();
        if(!empty($param['type'])){
            if($param['type']=='add'){
                return view('admin/admin/admin_insert');
            }else if($param['type']=='edit'){
                $notice=$this->admin->info($param['id']);
                return view('admin/admin/admin_update',['info'=>$notice]);
            }else if($param['type']=='token'){
                $data = $this->admin->info(session('admin_id'));
                return view('admin/admin/update',['info'=>$data]);
            }
        }
        return view('admin/admin/index');
    }
    /**
     * 主页数据
     */
    public function lists(Request $request){
        $param=$request->all();
        $data=$this->admin->lists($param);
        return $data?state('0','管理员列表',$data['data'],$data['count']):state('0','无数据','');
    }
    /**
     * 添加
     */
    public function insert(Request $request){
        $param = $request->all();
        $data = $this->admin->add($param);
        return $data? state(0,'添加成功',$data):state(1,'添加失败','');
    }
    /**
     * 修改
     */
    public function edit(Request $request,$id){
        $param = $request->all();
        $param['id'] = $id;
        $data = $this->admin->edit($param);
        return $data? state(0,'修改成功',$data):state(1,'修改失败','');
    }
    /**
     * 删除
     */
    public function del($id){
        $data = $this->admin->del($id);
        return $data? state(0,'删除成功',$data):state(1,'删除失败','');

    }

}
