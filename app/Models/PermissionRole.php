<?php

namespace App\Models;


class PermissionRole extends Base
{
    /**
     * 定义表名
     *
     * @var string
     */
    protected $table = 'permission_role';

    /**
     * 不使用created_at和updated_at
     *
     * @var
     */
    public $timestamps = false;


    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'permission_id',
        'role_id'
    ];

    /**
     * 添加数据
     *
     * @param  array $data 需要添加的数据
     * @return bool        是否成功
     */
    public function addData($data)
    {
        //添加数据
        $result=$this->create($data);
        if ($result) {
            session()->flash('alert-message','操作成功');
            session()->flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }





}
