<?php

namespace App\Http\Controllers\admin;

use App\Model\Order;
use App\Model\Record;
use App\Model\Config;
use App\Model\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class orderController extends Controller
{
    private $order;
    private $record;
    private $config;
    private $template;
    public function __construct(Order $order,Config $config,Template $template,Record $record)
    {
        $this->order=$order;
        $this->record=$record;
        $this->config=$config;
        $this->template=$template;
    }
    /**
     * 首页
     */
    public function index(){
        return view('admin/order/index');
    }
    public function pay(){
        return view('admin/order/pay');
    }
    public function unpaid(){
        return view('admin/order/unpaid');
    }
    public function complete(){
        return view('admin/order/complete');
    }
    public function fail(){
        return view('admin/order/fail');
    }
    public function reason(){
        $template=$this->template->alldata();
        return view('admin/order/reason',['info'=>$template]);
    }
    /**
     * 加急数据
     */
    public function lists(Request $request){
        $param=$request->all();
        $data=$this->order->lists($param);
        return $data?state('0','订单列表',$data['data'],$data['count']):state('1','无数据','');
    }
    /**
     * 数据
     */
    public function list(Request $request,$type){
        $param=$request->all();
        $param['type']=$type;
        $data=$this->order->list($param);
        return $data?state('0','订单列表',$data['data'],$data['count']):state('1','无数据','');
    }
    /**
     * 添加订单
     */
    public function orderadd(Request $request){
        //判断参数是否存在
        if(!$request->has('openid') || !$request->has('notice') || !$request->has('name')
            || !$request->has('phone')|| !$request->has('money')|| !$request->has('noticetime')
            || !$request->has('type') || !$request->has('urgent') || !$request->has('service')
            || !$request->has('amount') || !$request->has('overdue') || !$request->has('formid')){
            return state([2,'缺少参数','']);
        }
        $param=$request->all();
        $str="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        $strs=substr(str_shuffle($str),mt_rand(0,strlen($str)-11),1);
        $param['ordernumber']='Z'.date('ymdHis') .$strs;
        $param['status']=0;
        $data=$this->order->add($param);
        return $data?state('0','添加成功',$param):state('1','添加失败','');
    }
    /**
     *完成订单
     */
    public function edit($id){
        $this->order->edit($id);
        $oneinfo=$this->order->oneinfo($id);
        $data=$this->completetemplate($oneinfo->openid,$oneinfo->formid,$oneinfo->ordernumber,$oneinfo->notice,$oneinfo->name);
        return $data?state('0','发送成功',$data):state('1','发送失败','');
    }
    /**
     * 订单交易失败
     */
    public function titleedit(Request $request,$id){
        $param=$request->all();
        $config=$this->config->oneinfo();
        $order=$this->order->oneinfo($id);
        $nonce_str=createNonceStr();
        $str="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        $strs=substr(str_shuffle($str),mt_rand(0,strlen($str)-11),1);
        $ordernumbers='H'.date('ymdHis') .$strs;
        $refund=refund($config->appid,$config->mer_id,$nonce_str,$order->ordernumber,$ordernumbers,0.01,$config->msecret,$config->autograph,$config->templatecode);
        if($refund['return_code']=='SUCCESS' && $refund['result_code']=='SUCCESS'){
            $datas=array(
                'openid'=>$order->openid,
                'ordernumber'=>$order->ordernumber,
                'status'=>1,
                'money'=>$order->amount,
            );
            $this->record->add($datas);
            $this->order->turnfail($id);
            $data=$this->failtemplate($order->openid,$order->formid,$order->ordernumber,$order->notice,$param['title']);
            return $order?state('0','退还成功',$data):state('1','退还失败','');
        }else{
            return state('2','退还失败',$order);
        }
        return $data?state('0','发送成功',$data):state('1','发送失败','');
    }
    /**
     * 退款
     */
    public function refund($id){
        $config=$this->config->oneinfo();
        $order=$this->order->oneinfo($id);
        $refund=refund($config->appid,$config->mer_id,$order->ordernumber,$order->openid,$order->amount,$config->msecret,$config->autograph,$config->templatecode);
        return $refund;
    }
    /**
     * 转为失败
     */
    public function turnfail($id){
        $config=$this->config->oneinfo();
        $order=$this->order->oneinfo($id);
        $nonce_str=createNonceStr();
        $str="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        $strs=substr(str_shuffle($str),mt_rand(0,strlen($str)-11),1);
        $ordernumbers='H'.date('ymdHis') .$strs;
        $refund=refund($config->appid,$config->mer_id,$nonce_str,$order->ordernumber,$ordernumbers,0.01,$config->msecret,$config->autograph,$config->templatecode);
        if($refund['return_code']=='SUCCESS' && $refund['result_code']=='SUCCESS'){
            $datas=array(
                'openid'=>$order->openid,
                'ordernumber'=>$order->ordernumber,
                'status'=>1,
                'money'=>$order->amount,
            );
            $this->record->add($datas);
            $order=$this->order->turnfail($id);
            return $order?state('0','退还成功',$order):state('1','退还失败','');
        }else{
            return state('2','退还失败',$order);
        }

    }
    /**
     * 失败模板消息
     */
    public function failtemplate($openid,$formid,$ordernumber,$notice,$name){
        $config=$this->config->oneinfo();
        $path='/pages/index/index';
        $title='本订单被退回后将在1-2个工作日退回到您的支付账户，请注意查收。祝您生活愉快！';
        $result=templateMessage($config->appid,$config->secret,$config->fail_id,$openid,$path,$formid,$ordernumber,$notice,$name,$title);
        return $result?state('0','发送成功',$result):state('1','发送失败','');
    }
    /**
     * 完成模板消息
     */
    public function completetemplate($openid,$formid,$ordernumber,$notice,$name){
        $config=$this->config->oneinfo();
        $path='/pages/index/index';
        $result=templateMessage($config->appid,$config->secret,$config->complete_id,$openid,$path,$formid,$ordernumber,$notice,$name,'');
        return $result?state('0','发送成功',$result):state('1','发送失败','');
    }
    /**
     * 发送待支付模板消息
     */
    public function paytemplate(Request $request){
        $param=$request->all();
        $config=$this->config->oneinfo();
        $path='/pages/index/index';
        $con='您的处罚决定书应在15日内缴纳，否则将产生滞纳金，也会影响车辆及驾照年审';
        $result=templateMessage($config->appid,$config->secret,$config->template_id,$param['openid'],$path,$param['formid'],$param['ordernumber'],$param['amount'],$con,'');
        return $result?state('0','发送成功',$result):state('1','发送失败','');
    }
    /**
     * 支付订单
     */
    public function payorder(Request $request){
        if(!$request->has('ordernumber') || !$request->has('amount') || !$request->has('openid') || !$request->has('formid')){
            return state(2,'缺少参数','');
        }
        $param = $request->all();
        $config = $this->config->oneInfo();
        $amountmoney = $param['amount'];
        $ordernumber = $param['ordernumber'];
        $openid = $param['openid'];
        $appid = $config->appid;
        $mch_id = $config->mer_id;
        $mch_secret = $config->msecret;
        $notify_url = url('order/notify');//回调地址
        $body= "罚款代缴";
        $attach = json_encode(['ordernumber'=>$param['ordernumber'],'formid'=>$param['formid']]);
        $amountmoney=0.01;
        return initiatingPayment($amountmoney,$ordernumber,$openid,$appid,$mch_id,$mch_secret,$notify_url,$body,$attach);
    }
    /**
     * 支付订单
     */
    public function paymentorder(Request $request){
        $att= $request->all();
        $param=$this->order->oneinfo($att['id']);
        $config = $this->config->oneInfo();
        $amountmoney = $param['amount'];
        $ordernumber =  $param['ordernumber'];
        $openid = $param['openid'];
        $appid = $config->appid;
        $mch_id = $config->mer_id;
        $mch_secret = $config->msecret;
        $notify_url = url('order/notify');//回调地址
        $body= "罚款代缴";
        $attach = json_encode(['ordernumber'=>$param['ordernumber'],'formid'=>$param['formid']]);
        $amountmoney=0.01;
        $data=initiatingPayment($amountmoney,$ordernumber,$openid,$appid,$mch_id,$mch_secret,$notify_url,$body,$attach);
        $data['ordernumber']=$param['ordernumber'];
        $data['amount']=$param['amount'];
        return $data;
    }
    /**
     * 支付回调
     */
    public function notify(){
        $value = file_get_contents("php://input"); //接收微信参数
        if (!empty($value)) {
            $arr = xmlToArray($value);
            if($arr['result_code'] == 'SUCCESS' && $arr['return_code'] == 'SUCCESS'){
                $attach = json_decode($arr['attach'], true);
                $money = $arr['total_fee']/100;
                $ordernumber = $attach['ordernumber'];
                $data=array(
                    'openid'=>$arr['openid'],
                    'ordernumber'=>$ordernumber,
                    'status'=>0,
                    'money'=>$money,
                );
                writeLogs(json_encode($data));
                /**
                 * 执行添加充值记录
                 *
                 * $money
                 * $uid
                 * $order
                 */
                @$this->record->add($data);
                @$this->order->orderupdate($ordernumber);


                return 'SUCCESS';
            }else{

            }
        }
    }
    /**
     * 订单
     */
    public function payorderapi(Request $request){
        $param=$request->all();
        $data=$this->order->listorder($param);
        return $data?state('0','订单',$data):state('1','无数据','');
    }
}

