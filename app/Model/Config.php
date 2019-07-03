<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table='config';
    protected $fillable=[
        'id','appid','secret','complete_id','fail_id','template_id','content','latefee','urgent','service','mer_id','msecret','autograph','templatecode','created_at','updated_at'
    ];
    protected $hidden=[
        ''
    ];
    public function oneinfo(){
        return $this->first();
    }
    /**
     * 添加配置
     */
    public function add($param){
        $data['appid'] = !empty($param['appid'])? preg_replace('# #','',$param['appid']):'';
        $data['secret'] = !empty($param['secret'])? preg_replace('# #','',$param['secret']):'';
        $data['mer_id'] = !empty($param['mer_id'])? preg_replace('# #','',$param['mer_id']):'';
        $data['msecret'] = !empty($param['msecret'])? preg_replace('# #','',$param['msecret']):'';
        $data['autograph'] = !empty($param['autograph'])? preg_replace('# #','',$param['autograph']):'';
        $data['content'] = !empty($param['content'])? preg_replace('# #','',$param['content']):'';
        $data['service'] = !empty($param['service'])? preg_replace('# #','',$param['service']):'';
        $data['urgent'] = !empty($param['urgent'])? preg_replace('# #','',$param['urgent']):'';
        $data['latefee'] = !empty($param['latefee'])? preg_replace('# #','',$param['latefee']):'';
        $data['template_id'] = isset($param['template_id'])? preg_replace('# #','',$param['template_id']):'';
        $data['complete_id'] = isset($param['complete_id'])? preg_replace('# #','',$param['complete_id']):'';
        $data['fail_id'] = !empty($param['fail_id'])? preg_replace('# #','',$param['fail_id']):'';
        $data['templatecode'] = !empty($param['templatecode'])? preg_replace('# #','',$param['templatecode']):'';
        return $this->create($data);
    }
    /**
     * 编辑配置
     */
    public  function edit($param){
        if(!empty($param['appid'])){
            $data['appid'] = $param['appid'];
        }
        if(!empty($param['content'])){
            $data['content'] = $param['content'];
        }
        if(!empty($param['template_id'])){
            $data['template_id'] = $param['template_id'];
        }
        if(!empty($param['secret'])){
            $data['secret'] = $param['secret'];
        }
        if(!empty($param['complete_id'])){
            $data['complete_id'] = $param['complete_id'];
        }
        if(!empty($param['fail_id'])){
            $data['fail_id'] = $param['fail_id'];
        }
        if(!empty($param['mer_id'])){
            $data['mer_id'] = $param['mer_id'];
        }
        if(!empty($param['msecret'])){
            $data['msecret'] = $param['msecret'];
        }
        if(!empty($param['autograph'])){
            $data['autograph'] = $param['autograph'];
        }
        if(!empty($param['service'])){
            $data['service'] = $param['service'];
        }
        if(!empty($param['latefee'])){
            $data['latefee'] = $param['latefee'];
        }
        if(!empty($param['urgent'])){
            $data['urgent'] = $param['urgent'];
        }
        if(!empty($param['templatecode'])){
            $data['templatecode'] = $param['templatecode'];
        }
        $result = $this->where('id',$param['id'])->update($data);
        return $result;
    }
}
