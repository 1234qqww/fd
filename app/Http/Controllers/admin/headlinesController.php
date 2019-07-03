<?php

namespace App\Http\Controllers\admin;

use App\Model\Headlines;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class headlinesController extends Controller
{
    private $headlines;
    public function __construct(Headlines $headlines)
    {
        $this->headlines=$headlines;
    }
    public function index(Request $request){
        $param=$request->all();
        if(!empty($param['type'])){
            if($param['type']=='add'){
                return view('admin/headlines/headlines_insert');
            }else if($param['type']=='edit'){
                $notice=$this->headlines->info($param['id']);
                $notice->images=explode(',',$notice->image);
                return view('admin/headlines/headlines_update',['info'=>$notice]);
            }
        }
        return view('admin/headlines/index');
    }
    /**
     * 主页数据
     */
    public function lists(Request $request){
        $param=$request->all();
        $data=$this->headlines->lists($param);
        foreach ($data['data'] as $k=>&$val){
            $val->image=explode(',',$val->image);
        }
        return $data?state('0','头条列表',$data['data'],$data['count']):state('0','无数据','');
    }
    /**
     * 添加头条
     */
    public function add(Request $request){
        $param=$request->all();
        $data=$this->headlines->add($param);
        return $data?state('0','添加成功',$data):state('0','添加失败','');
    }
    /**
     * 修改头条
     */
    public function edit(Request $request,$id){
        $param=$request->all();
        $param['image']=implode(',',$param['image']);
        $data=$this->headlines->edit($param,$id);
        return $data?state('0','修改成功',$data):state('0','修改失败','');
    }
    /**
     * 删除头条
     */
    public function delete($id){
        $data = $this->headlines->del($id);
        return $data? state(0,'删除成功',$data):state(1,'删除失败','');

    }
    /**
     * 全部头条
     */
    public function headlines(){
        $data = $this->headlines->allData();
        foreach($data as $k=>&$val){
            $val->times=time_ago(strtotime($val->created_at));
            $val->image=explode(',', $val->image);
            if(count($val->image)>3){
                $val->image=array_slice($val->image,count($val->image)-3);
            }
        }
        return $data?state(0,'全部头条',$data):state(1,'无数据','');
    }
    /**
     * 头条详情
     */
    public function idheadlines(Request $request){
        $param = $request->all();
        $data = $this->headlines->info($param['headlines_id']);
        return $data?state(0,'头条详情',$data):state(1,'无数据','');
    }

}
