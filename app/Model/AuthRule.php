<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Validator;
use Session;

use app\Library\Org\Data;

class AuthRule extends Base
{
    //开启如删除
    use SoftDeletes;

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['id','pid','name','title','status','type','condition'];

    /**
     * 自动验证
     *
     * @param $data 需要验证的数据
     * @return bool 验证是否通过
     */
    public function validate($data)
    {
        $rules=[
            'name'=>'required',
            'title'=>'required'
        ];
        $attributes=[
            'name'=>'权限内容',
            'title'=>'权限名'
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

    /**
     * 获取全部菜单
     * @param  string $type tree获取树形结构 level获取层级结构
     * @param  string $order 排序字段
     * @return array       	结构数据
     */
    public function getTreeData($type='tree',$order='')
    {
        if (empty($order)) {
            $data=$this
                ->select('id','pid','name','title')
                ->get()
                ->toArray();
        }else{
            $data=$this
                ->select('id','pid','name','title')
                ->orderBy($order)
                ->get()
                ->toArray();
        }
        // 获取树形或者结构数据
        if($type=='tree'){
            $data=Data::tree($data,'title','id','pid');
        }elseif($type="level"){
            $data=Data::channelLevel($data,0,'&nbsp;','id');
        }
        return $data;
    }


}
