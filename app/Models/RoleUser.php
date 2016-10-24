<?php

namespace App\Models;

class RoleUser extends Base
{
    /**
     * 定义表名
     *
     * @var string
     */
    protected $table = 'role_user';

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
        'user_id',
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

    /**
     * 获取后台管理员列表数据
     *
     * @return mixed
     */
    public function getAdminUserList()
    {
        //获取数据
        $data=$this
            ->select('u.id','u.name','u.email','role_user.role_id','r.display_name')
            ->join('users as u','role_user.user_id','=','u.id')
            ->join('roles as r','role_user.role_id','=','r.id')
            ->get()
            ->toArray();
        // 获取第一条数据
        $first=$data[0];
        $first['display_name']=array();
        $user_data[$first['id']]=$first;
        // 组合数组
        foreach ($data as $k => $v) {
            foreach ($user_data as $m => $n) {
                $ids=array_map(function($a){return $a['id'];}, $user_data);
                if (!in_array($v['id'], $ids)) {
                    $v['display_name']=array();
                    $user_data[$v['id']]=$v;
                }
            }
        }
        // 组合管理员display_name数组
        foreach ($user_data as $k => $v) {
            foreach ($data as $m => $n) {
                if ($n['id']==$k) {
                    $user_data[$k]['display_name'][]=$n['display_name'];
                }
            }
            $user_data[$k]['display_name']=implode('、', $user_data[$k]['display_name']);
        }
        // 管理组title数组用顿号连接
        return $user_data;
    }

}
