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
     * 删除数据
     *
     * @param  array $map   where 条件数组形式
     * @return bool         是否成功
     */
    public function deleteData($map)
    {
        //暂时的应用场景是必须传id处理
        if (empty($map['id'])) {
            Session::flash('alert-message','此接口设计的必须传id');
            Session::flash('alert-class','alert-danger');
            return false;
        }
        //判断管理组下是否还有管理员
        $id_count=AuthGroupAccess::where('group_id', $map['id'])
            ->count();
        if ($id_count !== 0) {
            Session::flash('alert-message','请先取消此管理组下的所有管理员');
            Session::flash('alert-class','alert-danger');
            return false;
        }
        //软删除
        $result=$this
            ->where($map)
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
