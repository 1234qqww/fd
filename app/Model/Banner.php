<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //
    protected $table='image';
    protected $fillable=[
        'id','indexbanner','ownerbanner','created_at','updated_at'
    ];
    protected $hidden=[
        ''
    ];
    public function oneinfo(){
        return $this->first();
    }
    /**
     * 添加banner图
     */
    public function add($param){
        $data['indexbanner'] = !empty($param['indexbanner'])? preg_replace('# #','',$param['indexbanner']):'';
        $data['ownerbanner'] = !empty($param['ownerbanner'])? preg_replace('# #','',$param['ownerbanner']):'';
        return $this->create($data);
    }
    /**
     * 修改banner图
     */
    public  function edit($param){
        if(!empty($param['indexbanner'])){
            $data['indexbanner'] = $param['indexbanner'];
        }
        if(!empty($param['ownerbanner'])){
            $data['ownerbanner'] = $param['ownerbanner'];
        }
        $result = $this->where('id',$param['id'])->update($data);
        return $result;
    }

}
