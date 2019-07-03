<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table='complaint';
    protected $fillable=[
        'id','openid','content','created_at','updated_at'
    ];
    protected $hidden=[
        ''
    ];
    public function oneinfo(){
        return $this->first();
    }

    /**
     * @param $param
     * @return array
     * 投诉列表
     */
    public function lists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query = $this;
        if(!empty($param['key'])){
            $query = $query -> where('name','like',"%{$param['key']}%");
        }
        $offset = ($page-1)*$limit;
        $tot = $query->get()->count();
        $data = $query->offset($offset)->limit($limit)->get();
        return ['data'=>$data,'count'=>$tot];
    }
    /**
     * 添加投诉
     */
    public function add($param){
        $data['openid'] = !empty($param['openid'])? preg_replace('# #','',$param['openid']):'';
        $data['content'] = !empty($param['content'])? preg_replace('# #','',$param['content']):'';
        return $this->create($data);
    }
}
