<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Validator;
use Session;

use app\Library\Org\Data;

class AuthRule extends Model
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
     * @param $data 需要添加的数据
     * @return bool 是否成功
     */
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

    /**
     * 修改数据
     *
     * @param $data 需要添加的数据
     * @return bool 是否成功
     */
    public function editData($data)
    {
        //验证是否通过
        if (!$this->validate($data)) {
            return false;
        }
        $edit_data=[
            'name'=>$data['name'],
            'title'=>$data['title']
        ];
        //修改数据
        $result=$this
            ->where('id',$data['id'])
            ->update($edit_data);
        if ($result) {
            Session::flash('alert-message','修改成功');
            Session::flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
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
     * 排序
     * @param  $data 需要排序的数据
     * @return bool  是否成功
     */
    public function orderData($data)
    {
        if (empty($data)) {
            Session::flash('alert-message','没有需要排序的数据');
            Session::flash('alert-class','alert-success');
            return false;
        }
        //循环修改数据
        foreach ($data as $k => $v){
            $v = empty($v) ? null : $v;
            $edit_data=[
                'order_number'=>$v
            ];
            //修改数据
            $result=$this
                ->where('id',$k)
                ->update($edit_data);
        }

        if ($result) {
            Session::flash('alert-message','修改成功');
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
            Data::channelLevel($data,0,'&nbsp;','id');
        }
        return $data;
    }


}
