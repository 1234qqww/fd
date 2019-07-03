<?php

namespace App\Http\Controllers\admin;

use App\Model\Config;
use App\Model\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class templateController extends Controller
{
    private $template;
    private $config;
    public function __construct(Template $template,Config $config)
    {
        $this->template=$template;
        $this->config=$config;
    }
    //小程序消息模板
    public function index(Request $request){
        $param=$request->all();
        if(!empty($param['type'])){
            if($param['type']=='add'){
                return view('admin/template/template_insert');
            }else if($param['type']=='edit'){
                $notice=$this->template->oneinfo($param['id']);
                return view('admin/template/template_update',['info'=>$notice]);
            }
        }
        return view('admin/template/index');
    }

    /**
     * @param Request $request
     * @return array
     * 原因列表
     */
    public function lists(Request $request){
        $param=$request->all();
        $data=$this->template->lists($param);
        return $data?state('0','原因列表',$data['data'],$data['count']):state('1','无数据','');

    }
    /**
 * @param $ggg
 * @return string
 * 添加原因
 */
    public function add(Request $request){
        $param=$request->all();
        $data=$this->template->add($param);
        return $data?state('0','添加成功',''):state('1','添加失败','');
    }
    /**
     * @param $ggg
     * @return string
     * 修改原因
     */
    public function edit(Request $request,$id){
        $param=$request->all();
        $param['id']=$id;
        $data=$this->template->edit($param);
        return $data?state('0','修改成功',''):state('1','修改失败','');
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     * 删除原因
     */
    public function delete($id){
        $data=$this->template->del($id);
        return $data?state('0','删除成功',''):state('1','删除失败','');
    }

}


    //获取接口凭证


