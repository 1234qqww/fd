<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table='notice';
    protected $fillable=[
        'id','notice','sort','created_at','updated_at'
    ];
    protected $hidden=[
        ''
    ];
    /**
     * 通知列表
     */
    public function lists($param=[]){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query = $this;
        if(!empty($param['key'])){
            $query = $query -> where('notice','like',"%{$param['key']}%");
        }
        $offset = ($page-1)*$limit;
        $tot = $query->get()->count();
        $data = $query->offset($offset)->limit($limit)->orderBy('id','Desc')->get();
        return ['data'=>$data,'count'=>$tot];
    }
    /**
     * 通知详情
     */
    public function info($id){
        return $this->find($id);
    }

    /**
     * @param $param
     * @return mixed
     * 添加通知
     */
    public function add($param){
        $data['notice'] = !empty($param['notice'])? preg_replace('# #','',$param['notice']):'';
        $data['sort'] = isset($param['sort'])? preg_replace('# #','',$param['sort']):'';
        return $this->create($data);
    }
    /**
     * 修改通知
     */
    public function edit($param,$id){
        if(!empty($param['notice'])){
            $data['notice']=$param['notice'];
        }
        if(!empty($param['sort'])){
            $data['sort']=$param['sort'];
        }
        return $this->where('id',$id)->update($data);
    }
    /**
     * 删除通知
     */
    public function del($id){
        return $this->where('id',$id)->delete();
    }
    /**
     * 全部数据
     */
    public function allData(){
        return $this->orderBy('id','Desc')->get();
    }
}
