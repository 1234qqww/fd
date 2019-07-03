<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'admin';
    protected $fillable = [
        'id', 'username','password','status','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        ''
    ];

    public function lists ($param=[]){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query = $this;
        if(!empty($param['key'])){
            $query = $query -> where('username','like',"%{$param['key']}%");
        }
        $offset = ($page-1)*$limit;
        $tot = $query->get()->count();
        $data = $query->offset($offset)->limit($limit)->get();
        return ['data'=>$data,'count'=>$tot];
    }

    /**
     * 管理员添加
     */
    public  function add($param = []){
        $data['username'] = !empty($param['username'])?$param['username']:'';
        $data['password'] = !empty($param['password'])?sha1(md5($param['password'])):'';
        $data['status'] = isset($param['status'])?$param['status']:'';
        return $this->create($data);

    }
    /**
     * 管理员删除
     */
    public function del($id){
        return $this->where('id',$id)->delete();
    }
    /**
     * 管理员详情
     */
    public function info($id){
        return $this->find($id);
    }
    /**
     * 管理员修改
     */
    public  function edit($param){
        if(!empty($param['username'])){
            $data['username'] = $param['username'];
        }
        if(!empty($param['password'])){
            $data['password'] = sha1(md5($param['password']));
        }
        if(isset($param['status'])){
            $data['status'] = $param['status'];
        }
        $info = $this->info($param['id']);
        if($info->password == $param['password']){
            unset($data['password']);
        }
        $result = $this->where('id',$param['id'])->update($data);
        return $result;
    }

    /**
     * @param array $param
     * @return array
     * 检测登录
     */
    public function check(array $param = []){
        $username = $param['name'];
        $password = $param['password'];
        $name = $this->where('username',$username)->first();
        if(!empty($name)){
            $password = sha1(md5($password));
            $pass = $this->where('username',$username)->where('password',$password)->first();
            if(!empty($pass)){
                $type = $this->where('username',$username)->where('password',$password)->where('status',0)->first();
                if(!$type){
                    $this->where('id',$pass->id)->update(['updated_at'=>date('Y-m-d H:i:s')]);
                    session(['admin_id' => $pass->id]);
                    session(['admin_user' => $pass->username]);
                    return ['code'=>0,'msg'=>'登录成功','data'=>$pass];
                }else{
                    return ['code'=>3,'msg'=>'该账号已被禁用','data'=>''];
                }
            }else{
                return ['code'=>2,'msg'=>'密码不正确','data'=>''];
            }
        }else{
            return ['code'=>1,'msg'=>'用户名不存在','data'=>''];
        }
    }

}
