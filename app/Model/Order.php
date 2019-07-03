<?php

namespace App\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table='order';
    protected $fillable=[
        'id','ordernumber','formid','notice','phone','money','noticetime','type','openid','service','amount','name','overdue','urgent','status','created_at','updated_at'
    ];
    protected $hidden=[
        ''
    ];
    /**
     * @param $param
     * @return array
     * 加急订单
     */
    public function lists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query = $this;
        if(!empty($param['key'])){
            $query=$query->where(DB::raw('concat(openid,ordernumber,notice)'),'like','%'.$param['key'].'%');
        }
        $offset = ($page-1)*$limit;
        $tot = $query->where('type',1)->where('status',1)->get()->count();
        $data = $query->offset($offset)->limit($limit)->where('type',1)->where('status',1)->orderBy('id','Desc')->get();
        return ['data'=>$data,'count'=>$tot];
    }
    /**
     * @param $param
     * @return array
     * 订单列表
     */
    public function list($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query = $this;
        if(!empty($param['key'])){
            $query=$query->where(DB::raw('concat(openid,ordernumber,notice)'),'like','%'.$param['key'].'%');
        }
        $offset = ($page-1)*$limit;
        $tot = $query->where('status',$param['type'])->get()->count();
        $data = $query->offset($offset)->limit($limit)->where('status',$param['type'])->orderBy('updated_at','Desc')->get();
        return ['data'=>$data,'count'=>$tot];
    }
    /**
     * @param $param
     * @return array
     * 订单
     */
    public function listorder($param){
        if($param['status']==''){
            return $this->where('openid',$param['openid'])->orderBy('status','asc')->get();
        }else{
            return $this->where('status',$param['status'])->where('openid',$param['openid'])->orderBy('status','asc')->get();

        }
    }
    /**
     * 完成定单
     */
    public function edit($id){
        return $this->where('id',$id)->update(['status'=>2]);
    }
    /**
     * 订单交易失败
     */
    public function titleedit($id){
        return $this->where('id',$id)->update(['status'=>3]);
    }
    /**
     * 订单详情
     */
    public function oneinfo($id){
        return $this->find($id);
    }
    /**
     * 创建订单
     */
    public function add($param){
        $data['ordernumber'] = !empty($param['ordernumber'])? preg_replace('# #','',$param['ordernumber']):'';
        $data['notice'] = !empty($param['notice'])? preg_replace('# #','',$param['notice']):'';
        $data['phone'] = !empty($param['phone'])? preg_replace('# #','',$param['phone']):'';
        $data['money'] = !empty($param['money'])? preg_replace('# #','',$param['money']):'';
        $data['noticetime'] = !empty($param['noticetime'])? preg_replace('# #','',$param['noticetime']):'';
        $data['type'] = isset($param['type'])? preg_replace('# #','',$param['type']):'';
        $data['openid'] = !empty($param['openid'])? preg_replace('# #','',$param['openid']):'';
        $data['service'] = !empty($param['service'])? preg_replace('# #','',$param['service']):'';
        $data['amount'] = !empty($param['amount'])? preg_replace('# #','',$param['amount']):'';
        $data['name'] = !empty($param['name'])? preg_replace('# #','',$param['name']):'';
        $data['overdue'] = !empty($param['overdue'])? preg_replace('# #','',$param['overdue']):'';
        $data['urgent'] = !empty($param['urgent'])? preg_replace('# #','',$param['urgent']):'';
        $data['status'] = isset($param['status'])? preg_replace('# #','',$param['status']):'';
        $data['formid'] = isset($param['formid'])? preg_replace('# #','',$param['formid']):'';
        return $this->create($data);
    }
    /**
     * 修改订单状态
     */
    public function orderupdate($ordernumber){
        return $this->where('ordernumber',$ordernumber)->update(['status'=>1]);

    }
    /**
     * 通过订单号查询订单
     */
    public function ordernumber($ordernumber){
        return $this->where('ordernumber',$ordernumber)->first();
    }
    /**
     * 查询支付订单数
     */
    public function userorder($openid,$status){
        return $this->where('openid',$openid)->where('status',$status)->count();
    }
    /**
     * 成功转为失败
     */
    public function turnfail($id){
        return $this->where('id',$id)->update(['status'=>3]);
    }
    /**
     * 统计订单
     */
    public function censusorder($openid){
        return $this->where('openid',$openid)->where('status',2)->orWhere ('status',1)->get();
    }
    /**
     * 通过openid查询订单
     */
    public function openorder($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query = $this;
        if(!empty($param['key'])){
            $query = $query -> where('ordernumber','like',"%{$param['key']}%");
        }
        $offset = ($page-1)*$limit;
        $tot = $query->where('openid',$param['openid'])->get()->count();
        $data = $query->offset($offset)->limit($limit)->where('openid',$param['openid'])->orderBy('status','asc')->get();
        return ['data'=>$data,'count'=>$tot];
    }
}
