<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Validator;
use Session;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //开启如删除
    use SoftDeletes;

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'password',
        'avatar',
        'email',
        'email_code',
        'phone',
        'status',
        'last_login_ip',
        'last_login_time'
    ];

    /**
     * 自动验证
     *
     * @param $data 需要验证的数据
     * @return bool 验证是否通过
     */
    public function validate($data)
    {
        //检测用户名是否存在
        if (!empty($data['name'])) {
            $name_count=$this
                ->where('name',$data['name'])
                ->count();
            if ($name_count !==0) {
                Session::flash('alert-message','用户名已存在');
                Session::flash('alert-class','alert-danger');
                return false;
            }
        }

        //检测邮箱是否存在
        if (!empty($data['email'])) {
            $name_count=$this
                ->where('email',$data['email'])
                ->count();
            if ($name_count !==0) {
                Session::flash('alert-message','邮箱已存在');
                Session::flash('alert-class','alert-danger');
                return false;
            }
        }

        //检测手机号是否存在
        if (!empty($data['phone'])) {
            $name_count=$this
                ->where('phone',$data['phone'])
                ->count();
            if ($name_count !==0) {
                Session::flash('alert-message','手机号已存在');
                Session::flash('alert-class','alert-danger');
                return false;
            }
        }

        return true;
    }

    /**
     * @param 需要添加的数据 $data
     * @return bool
     */
    public function addData($data)
    {
        //验证是否通过
        if (!$this->validate($data)) {
            return false;
        }
        //如果传password 则加密
        if (!empty($data['password'])) {
            $data['password']=bcrypt($data['password']);
        }
        //添加数据
        $result=$this
            ->create($data)
            ->id;
        if ($result) {
            Session::flash('alert-message','添加成功');
            Session::flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }

    /**
     * 修改数据
     *
     * @param $map  where条件
     * @param $data 需要修改的数据
     * @return bool 是否成功
     */
    public function editData($map, $data)
    {
        //如果传password 则加密
        if (!empty($data['password'])) {
            $data['password']=bcrypt($data['password']);
        }

        //修改数据
        $result=$this
            ->where($map)
            ->update($data);
        if ($result) {
            Session::flash('alert-message','修改成功');
            Session::flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }

}
