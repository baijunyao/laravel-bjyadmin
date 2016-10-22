<?php

namespace App\models;

use app\Library\Org\Data;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['id','pid','name','display_name','description'];

    /**
     * 添加数据
     *
     * @param  array $data 需要添加的数据
     * @return bool        是否成功
     */
    public function addData($data)
    {
        //添加数据
        $result=$this
            ->create($data)
            ->id;
        if ($result) {
            session()->flash('alert-message','添加成功');
            session()->flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }

    /**
     * 修改数据
     *
     * @param  array $map  where条件
     * @param  array $data 需要修改的数据
     * @return bool        是否成功
     */
    public function editData($map, $data)
    {
        //修改数据
        $result=$this
            ->where($map)
            ->update($data);
        if ($result) {
            session()->flash('alert-message','修改成功');
            session()->flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }

    /**
     * 删除数据
     *
     * @param  $id  需要删除的id
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
            session()->flash('alert-message','必须先删除子权限');
            session()->flash('alert-class','alert-danger');
            return false;
        }
        //删除数据
        $result=$this
            ->where('id',$id)
            ->delete();
        if ($result) {
            session()->flash('alert-message','删除成功');
            session()->flash('alert-class','alert-success');
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
                ->select('id','pid','name','display_name')
                ->get()
                ->toArray();
        }else{
            $data=$this
                ->select('id','pid','name','display_name')
                ->orderBy($order)
                ->get()
                ->toArray();
        }
        // 获取树形或者结构数据
        if($type=='tree'){
            $data=Data::tree($data,'display_name','id','pid');
        }elseif($type="level"){
            $data=Data::channelLevel($data,0,'&nbsp;','id');
        }
        return $data;
    }

}
