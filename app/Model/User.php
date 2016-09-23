<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Validator;
use Session;

class User extends Base
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
        'username',
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
        if (!empty($data['username'])) {
            $name_count=$this
                ->where('username',$data['username'])
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

    public function addData($data)
    {
        //验证是否通过
        if (!$this->validate($data)) {
            return false;
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


}
