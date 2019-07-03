<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Complaint;
class complaintController extends Controller
{
    private $complaint;
    public function __construct(Complaint $complaint)
    {
        $this->complaint=$complaint;
    }
    public function index(){
        return view('admin/complaint/index');
    }

    /**
     * @param Request $request
     * @return array
     * 投诉列表
     */
    public function lists(Request $request){
        $param=$request->all();
        $data=$this->complaint->lists($param);
        return $data?state('0','投诉列表',$data['data'],$data['count']):state('0','无数据','');
    }
    /**
     * 添加投诉
     */
    public function complaintapi(Request $request){
        $param=$request->all();
        $data=$this->complaint->add($param);
        return $data?state('0','我们正在处理',$data):state('1','内容缺失','');
    }

}
