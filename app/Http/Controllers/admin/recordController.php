<?php

namespace App\Http\Controllers\admin;

use App\Model\Record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class recordController extends Controller
{
    private $record;

    public function __construct(Record $record)
    {
        $this->record=$record;
    }
    public function index(Request $request){
        return view('admin/record/index');
    }
    /**
 * @param Request $request
 * @return array
 * 充值列表
 */
    public function lists(Request $request){
        $param=$request->all();
        $data=$this->record->lists($param);
        return $data?state('0','充值列表',$data['data'],$data['count']):state('1','无数据','');
    }
    public function drawback(){
        return view('admin/record/drawback');
    }
    /**
     * @param Request $request
     * @return array
     * 退款列表
     */
    public function list(Request $request){
        $param=$request->all();
        $data=$this->record->list($param);
        return $data?state('0','退款列表',$data['data'],$data['count']):state('1','无数据','');
    }
}
