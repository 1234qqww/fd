<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'question';
//    public $timestamps = false;
    protected $fillable = [
        'id','name','content','sort','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        ''
    ];

    public function lists ($param=[]){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query = $this;
        if(!empty($param['key'])){
            $query = $query -> where('name','like',"%{$param['key']}%");
        }
        $offset = ($page-1)*$limit;
        $tot = $query->get()->count();
        $data = $query->offset($offset)->limit($limit)->orderBy('id','Desc')->get();
        return ['data'=>$data,'count'=>$tot];
    }

    /**
     * 帮助添加
     */
    public  function add($param = []){
        $data['name'] = !empty($param['name'])?$param['name']:'';
        $data['content'] = !empty($param['content'])?$param['content']:'';
        $data['sort'] = !empty($param['sort'])?$param['sort']:'';
        return $this->create($data);

    }
    /**
     * 帮助删除
     */
    public function dele($id){
        return $this->where('id',$id)->delete();
    }
    /**
     * 帮助详情
     */
    public function info($id){
        return $this->find($id);
    }
    /**
     * 管理员修改
     */
    public  function admin_edit($param){
        if(!empty($param['name'])){
            $data['name'] = $param['name'];
        }
        if(!empty($param['content'])){
            $data['content'] = $param['content'];
        }
        if(!empty($param['sort'])){
            $data['sort'] = $param['sort'];
        }
        $result = $this->where('id',$param['id'])->update($data);
        return $result;
    }
    /**
     * 全部数据
     */
    public function allData(){
        return $this->orderBy('id','Desc')->get();
    }
}
