<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = 'record';
    protected $fillable = [
        'id','openid','ordernumber','money','status','created_at','updated_at'
    ];
    protected $hidden = [
        ''
    ];
    public function lists ($param=[]){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query = $this;
        if(!empty($param['key'])){
            $query = $query -> where('openid','like',"%{$param['key']}%");
        }
        $offset = ($page-1)*$limit;
        $tot = $query->where('status',0)->get()->count();
        $data = $query->offset($offset)->where('status',0)->limit($limit)->orderBy('id','Desc')->get();
        return ['data'=>$data,'count'=>$tot];
    }

    /**
     * @param array $param
     * @return array
     * 退款列表
     */
    public function list ($param=[]){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query = $this;
        if(!empty($param['key'])){
            $query = $query -> where('openid','like',"%{$param['key']}%");
        }
        $offset = ($page-1)*$limit;
        $tot = $query->get()->count();
        $data = $query->offset($offset)->where('status',1)->limit($limit)->orderBy('id','Desc')->get();
        return ['data'=>$data,'count'=>$tot];
    }
    /**
     * 添加充值记录
     */
    public  function add($param = []){
        $data['openid'] = isset($param['openid'])?$param['openid']:'';
        $data['ordernumber'] = isset($param['ordernumber'])?$param['ordernumber']:'';
        $data['money'] = isset($param['money'])?$param['money']:'';
        $data['status'] = isset($param['status'])?$param['status']:'';
        return $this->create($data);
    }
}
