<?php
namespace App\Models;

use DB;
use Auth;
use app\Library\Org\Data;

class AdminNav extends Base
{
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
     * @param  array $map   where 条件数组形式
     * @return bool         是否成功
     */
    public function deleteData($map)
    {
        //暂时的应用场景是必须传id处理
        if (empty($map['id'])) {
            session()->flash('alert-message','此接口设计的必须传id');
            session()->flash('alert-class','alert-danger');
            return false;
        }
        //查找子权限的数量
        $pids=$this
            ->where('pid', $map['id'])
            ->count();
        if ($pids !== 0) {
            session()->flash('alert-message','必须先删除子菜单');
            session()->flash('alert-class','alert-danger');
            return false;
        }
        //删除数据
        $result=$this
            ->where($map)
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
     * 排序
     * @param  array $data 需要排序的数据
     * @return bool        是否成功
     */
    public function orderData($data)
    {
        //如果存在_token字段；则删除
        if (isset($data['_token'])) {
            unset($data['_token']);
        }
        //判断是否有需要排序的字段
        if (empty($data)) {
            session()->flash('alert-message','没有需要排序的数据');
            session()->flash('alert-class','alert-error');
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
            session()->flash('alert-message','修改成功');
            session()->flash('alert-class','alert-success');
            return $result;
        }else{
            return false;
        }
    }

    /**
     * 获取全部菜单
     * @param  string $type  tree获取树形结构 level获取层级结构
     * @param  string $order 排序字段
     * @return array       	 结构数据
     */
    public function getTreeData($type='tree',$order='')
    {
        // 判断是否需要排序
        if (empty($order)) {
            $data=$this->get()->toArray();
        }else{
            $data=$this
                ->orderBy(DB::raw('order_number IS NULL,'.$order))
                ->get()
                ->toArray();
        }

        //获取当前登录的用户
        $user = Auth::user();

        // 获取树形或者结构数据
        if($type=='tree'){
            $data=Data::tree($data,'name','id','pid');
        }elseif($type="level"){
            $data=Data::channelLevel($data,0,'&nbsp;','id');
            // 显示有权限的菜单
            foreach ($data as $k => $v) {
                //判断顶级菜单是否有权限
                if ($user->can($v['mca'])) {
                    //判断子级菜单是否有权限
                    foreach ($v['_data'] as $m => $n) {
                        if (!$user->can($n['mca'])) {
                            unset($data[$k][$m]);
                        }
                    }
                }else{
                    unset($data[$k]);
                }
            }
        }
        return $data;
    }
}
