<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Question;

class questionController extends Controller
{
    private $question;
    public function __construct(Question $question)
    {
        $this->question=$question;
    }

    /**
     * 常见问题
     */
    public function question(Request $request){
        $param = $request->all();
        if(!empty($param['type'])){
            if($param['type'] == 'add'){
                return view('admin/helpcenter/helpcenter_insert');
            }else if($param['type'] == 'edit'){
                $info = $this->question->info($param['id']);
                return view('admin/helpcenter/helpcenter_update',['info'=>$info]);
            }
        }
        return view('admin/helpcenter/helpcenter');
    }

    public function questionLists(Request $request){
        $param = $request->all();
        $data = $this->question->lists($param);
        return $data? state(0,'帮助列表',$data['data'],$data['count']):state(0,'无数据','','');
    }
    /**
     * 添加常见问题
     */
    public function questionInsert(Request $request){
        $param = $request->all();
        $data = $this->question->add($param);
        return $data? state(0,'添加成功',$data):state(1,'添加失败','');

    }
    /**
     * 删除常见问题
     */
    public function questionDel($id){
        $data = $this->question->dele($id);
        return $data? state(0,'删除成功',$data):state(1,'删除失败','');

    }
    /**
     * 修改常见问题
     */
    public function questionEdit(Request $request,$id){
        $param = $request->all();
        $param['id'] = $id;
        $data = $this->question->admin_edit($param);
        return $data? state(0,'修改成功',$data):state(1,'修改失败','');

    }
    /**
     * 常见问题全部数据
     */
    public function questionAllData(Request $request){
        $data = $this->question->allData();
        return $data?state(0,'常见问题',$data):state(1,'常见问题','');
    }
    /**
     * 通过问题id获取问题详情
     */
    public function idgetquestion(Request $request){
        $param = $request->all();
        $data = $this->question->info($param['question_id']);
        return $data?state(0,'问题详情',$data):state(1,'问题详情','');
    }

}
