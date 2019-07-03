<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'template';
    protected $fillable = [
        'id','title','created_at','updated_at'
    ];
    protected $hidden = [
        ''
    ];
    /**
     * 全部消息
     */
    public function lists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query = $this;
        if(!empty($param['key'])){
            $query = $query -> where('title','like',"%{$param['key']}%");
        }
        $offset = ($page-1)*$limit;
        $tot = $query->get()->count();
        $data = $query->offset($offset)->limit($limit)->orderBy('id','Desc')->get();
        return ['data'=>$data,'count'=>$tot];
    }


    /**
     * @param $param
     * @return mixed
     * 添加原因
     */
    public function add($param){
        $data['title'] = !empty($param['title'])?$param['title']:'';
        return $this->create($data);
    }
    /**
 * @param $param
 * @return mixed
 * 修改原因
 */
    public function edit($param){
        if(!empty($param['title'])){
            $data['title'] = $param['title'];
        }
        $result = $this->where('id',$param['id'])->update($data);
        return $result;
    }
    /**
     * @param $param
     * @return mixed
     * 删除原因
     */
    public function del($id){
        return $this->where('id',$id)->delete();
    }
    /**
     * @param $param
     * @return mixed
     * 查询原因
     */
    public function sel($template){
        return $this->where('template_id',$template)->first();
    }
    /**
     * 原因详情
     */
    public function oneinfo($id){
        return $this->find($id);
    }
    /**
     * 全部数据
     */
    public function alldata(){
        return $this->get();
    }


}
