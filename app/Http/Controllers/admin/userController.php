<?php

namespace App\Http\Controllers\admin;

use App\Model\Order;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class userController extends Controller
{
    private $user;
    private $order;
    public function __construct(User $user,Order $order)
    {
        $this->user=$user;
        $this->order=$order;
    }
    public function index(){
        return view('admin/user/index');
    }
    public function lists(Request $request){
        $param = $request->all();
        $data = $this->user->lists($param);
        if($data){
           $dat= $data['data']->toArray();
            foreach ($dat as $k=>&$val){
                $val['payorder']=$this->order->userorder($val['openid'],1);
                $val['nopayorder']=$this->order->userorder($val['openid'],0);
            }
            $data['data']=$dat;
        }
        return $data? state(0,'用户列表',$data['data'],$data['count']):state(0,'无数据','','');
    }
    /**
     * 用户订单
     */
    public function userorder(Request $request){
        $param=$request->all();
        return view('admin/user/userorder',['openid'=>$param['openid']]);
    }
    public function orderlist(Request $request,$openid){
        $param=$request->all();
        $param['openid']=$openid;
        $data= $this->order->openorder($param);
        return $data? state(0,'订单数据',$data['data'],$data['count']):state(0,'无数据','','');
    }
    /**
     * 统计
     */
    public function census(){
        return view('admin/user/census');
    }
    public function censuslist(Request $request){

        $param=$request->all();
        $order=$this->user->getdata($param);
        if($order){
            $data=[];
            $money=0;
            $num=0;
            $count=0;
            $dat= $order->toArray();
            foreach ($dat as $k=>&$val){
                $status=1;
                $censusorder=$this->order->censusorder($val['openid']);
                $userorder=$this->order->userorder($val['openid'],$status);
                if($censusorder){
                    foreach ($censusorder as $key=>$value){
                        $money+=$value->amount;
                        $num++;
                    }
                }
                $data[$k]['id']=$val['id'];
                $data[$k]['openid']=$val['openid'];
                $data[$k]['amount']=$money;
                $data[$k]['num']=$num;
                $count=$userorder;
            }
            return state('0','统计列表',$data,$count);
        }
        return state('1','无数据','');


    }

}
