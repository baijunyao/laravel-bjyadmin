<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'display_name',
        'description'
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
        //判断管理组下是否还有管理员
        $id_count=RoleUser::where('role_id', $map['id'])
            ->count();
        if ($id_count !== 0) {
            session()->flash('alert-message','请先取消此管理组下的所有管理员');
            session()->flash('alert-class','alert-danger');
            return false;
        }
        //软删除
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




}
