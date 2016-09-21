<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Validator;
use Session;

class AuthGroup extends Base
{
    //开启如删除
    use SoftDeletes;

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['id','title','status','rules'];

    /**
     * 自动验证
     *
     * @param $data 需要验证的数据
     * @return bool 验证是否通过
     */
    public function validate($data)
    {
        $rules=[
            'title'=>'required'
        ];
        $attributes=[
            'title'=>'用户组名'
        ];
        $validator=Validator::make($data,$rules,[],$attributes);
        if ($validator->fails()) {
            $error=$validator->messages()->first();
            Session::flash('alert-message',$error);
            Session::flash('alert-class','alert-danger');
            return false;
        }
        return true;
    }

    /**
     * 添加数据
     *
     * @param  $id  需要添加的数据
     * @return bool 是否成功
     */
    public function deleteData($id)
    {
        //查找子权限的数量
        $pids=$this
            ->where('pid', $id)
            ->count();
        //如果有子权限；必须先删除子权限
        if ($pids !== 0) {
            Session::flash('alert-message','必须先删除子权限');
            Session::flash('alert-class','alert-danger');
            return false;
        }
        //删除数据
        $result=$this
            ->where('id',$id)
            ->delete();
        if ($result) {
            Session::flash('alert-message','删除成功');
            Session::flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }
}
