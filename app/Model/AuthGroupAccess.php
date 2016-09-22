<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Validator;
use Session;

class AuthGroupAccess extends Base
{
    use SoftDeletes;

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['uid','group_id'];

    /**
     * 自动验证
     *
     * @param $data 需要验证的数据
     * @return bool 验证是否通过
     */
    public function validate($data)
    {
        $rules=[
            'uid'=>'required',
            'group_id'=>'required'
        ];
        $attributes=[
            'uid'=>'用户id',
            'group_id'=>'用户组id'
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
     * @param 需要添加的数据 $data
     * @return bool
     */
    public function addData($data)
    {
        //如果存在_token字段；则删除
        if (isset($data['_token'])) {
            unset($data['_token']);
        }
        //验证是否通过
        if (!$this->validate($data)) {
            return false;
        }
        //判断是否已经存在 包括软删除的
        $count=$this
            ->withTrashed()
            ->where($data)
            ->count();
        if ($count !==0) {
            //恢复软删除
            $this->where($data)->restore();
            Session::flash('alert-message','设置成功');
            Session::flash('alert-class','alert-success');
            return true;
        }
        //添加数据
        $result=$this
            ->create($data)
            ->id;
        if ($result) {
            Session::flash('alert-message','设置成功');
            Session::flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }


    /**
     * 添加数据
     *
     * @param  $data  需要添加的数据
     * @return bool 是否成功
     */
    public function deleteData($data)
    {
        //验证是否通过
        if (!$this->validate($data)) {
            return false;
        }
        //恢复软删除
        $result=$this
            ->where($data)
            ->delete();
        if ($result) {
            Session::flash('alert-message','设置成功');
            Session::flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }


}
