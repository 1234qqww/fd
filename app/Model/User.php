<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table='user';
    protected $fillable=[
        'id','openid','payorder','nopayorder','created_at','updated_at'
    ];
    protected $hidden=[
        ''
    ];
    /**
     * @param $param
     * @return array
     * 用户列表
     */
    public function lists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query = $this;
        if(!empty($param['key'])){
            $query = $query -> where('openid','like',"%{$param['key']}%");
        }
        $offset = ($page-1)*$limit;
        $tot = $query->get()->count();
        $data = $query->offset($offset)->orderBy('id','Desc')->limit($limit)->get();
        return ['data'=>$data,'count'=>$tot];
    }
    public function oneinfo($openid){
        return $this->where('openid',$openid)->first();
    }
    /**
     * 修改登录时间
     */
    public function updates($time,$openid){
        return $this->where('openid',$openid)->update(['updated_at'=>$time]);
    }
    /**
     * 创建用户
     */
    public function add($param){
        $data['openid'] = !empty($param['openid'])? preg_replace('# #','',$param['openid']):'';
        $data['payorder'] = 0;
        $data['nopayorder'] = 0;
        return $this->create($data);
    }
    /**
     * 全部数据
     */
    public function getdata($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];

        $offset = ($page-1)*$limit;
        $data = $this->offset($offset)->limit($limit)->orderBy('id','asc')->get();
        return $data;
    }

}
