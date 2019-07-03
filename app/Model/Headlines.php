<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Headlines extends Model
{
    protected $table='headlines';
    protected $fillable=[
        'id','title','content','image','sort','reading','created_at','updated_at'
    ];
    protected $hidden=[
        ''
    ];
    /**
     * 车主头条
     */
    public function lists($param=[]){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query = $this;
        if(!empty($param['key'])){
            $query = $query -> where('title','like',"%{$param['key']}%");
        }
        $offset = ($page-1)*$limit;
        $tot = $query->get()->count();
        $data = $query->offset($offset)->orderBy('id','Desc')->limit($limit)->get();
        return ['data'=>$data,'count'=>$tot];
    }
    /**
     * 头条详情
     */
    public function info($id){
        return $this->find($id);
    }
    /**
     * 删除头条
     */
    public function del($id){
        return $this->where('id',$id)->delete();
    }
    /**
     * @param $param
     * @return mixed
     * 添加头条
     */
    public function add($param){
        $data['title'] = !empty($param['title'])? preg_replace('# #','',$param['title']):'';
        $data['content'] = isset($param['content'])? preg_replace('# #','',$param['content']):'';
        $data['image'] = isset($param['image'])? preg_replace('# #','',$param['image']):'';
        $data['sort'] = isset($param['sort'])? preg_replace('# #','',$param['sort']):0;
        $data['reading'] = isset($param['reading'])? preg_replace('# #','',$param['reading']):0;
        return $this->create($data);
    }
    /**
     * 全部数据
     */
    public function allData(){
        return $this->orderBy('id','Desc')->get();
    }
    /**
     * 修改头条
     */
    public function edit($param,$id){
        if(!empty($param['title'])){
            $data['title']=$param['title'];
        }
        if(!empty($param['content'])){
            $data['content']=$param['content'];
        }
        if(!empty($param['image'])){
            $data['image']=$param['image'];
        }
        if(!empty($param['sort'])){
            $data['sort']=$param['sort'];
        }
        if(!empty($param['reading'])){
            $data['reading']=$param['reading'];
        }
        return $this->where('id',$id)->update($data);
    }
}
