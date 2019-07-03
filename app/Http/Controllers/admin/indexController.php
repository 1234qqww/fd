<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Config;
use App\Model\User;

class indexController extends Controller
{
    private $config;
    private $user;
    public function __construct(Config $config,User $user)
    {
        $this->config=$config;
        $this->user=$user;
    }

    //
    public function index(){
        return view('admin/public/layout');
    }

    /**
     * @param Request $request
     * @return string
     * 图片上传
     */
    public function upload(Request $request){
        $file = $request->file('file');
        $path = 'upload/';
        return upload($file,$path);
    }

    /**
     * @param Request $request
     * @return array
     * 文本编辑器的图片上传
     */
    public function  editUpload(Request $request){
        $file = $request->file('file');
        $path = '/images/';
        $files = json_decode(upload($file,$path),true);
        $data[] = $files['url'];
        return  ['errno'=>0,'data'=>$data,];
    }
    /**
     * 上传文件
     */
    public function update(Request $request){
        $file = $request->file('file');
        // 判断文件是否上传
        if ($file) {
            // 获取后缀名
            $ext=$file->getClientOriginalExtension();
            // 新的文件名
            $newFile=date('YmdHis',time()).'_'.rand().".".$ext;
            // 上传文件操作
            $path = public_path().'/cert/';
            if($file->move($path,$newFile)){
                return json_encode(['code'=>0,'msg'=>'文件信息','url'=>$newFile]);
            }
        }
    }
    public function login(Request $request){
        $param = $request->all();
        if (empty($param['code'])) {
            return state(2, '缺少参数', '');
        }
        $config = $this->config->oneInfo();
        $openid = getOpenid($config->appid,$config->secret,$param['code']);
        if (isset($openid['openid'])) {
            $user = $this->user->oneinfo($openid['openid']);
            if($user){
                $openid = $user->openid;
                $time=date('Y-m-d H:i:s',time());
                $this->user->updates($time,$openid);
                return state(0,'登录成功',$openid);
            }else{
                $data['openid'] = $openid['openid'];
                $result = $this->user->add($data);
                if (!empty($result)) {
                    $openid = $result->openid;
                    return state(4, '会员注册成功', $openid);
                }else{
                    return state(1, '会员注册失败，请重新注册', '');
                }
            }
        } else {
            return state(3, '获取openid失败', '');
        }
    }
}
