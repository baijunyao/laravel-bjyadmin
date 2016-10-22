<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Http\Requests;
use App\Models\Permission;
use App\Http\Requests\Role\Store;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * 用户组列表
     *
     * @param  \App\Models\Role       $role 用户组模型
     * @return \Illuminate\Http\Response
     */
    public function index(Role $role)
    {
        $data=$role::all()->toArray();
        $assign=[
            'data'=>$data
        ];
        return view('admin/role/index', $assign);
    }

    /**
     * 添加用户组
     *
     * @param  \App\Http\Requests\Role\Store  $request
     * @param  \App\Models\Role      $role 用户组模型
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request, Role $role)
    {
        $data=$request->except('_token');
        p($data);
        $role->addData($data);
        return redirect('admin/role/index');
    }


    /**
     * 修改用户组
     *
     * @param  \App\Http\Requests\Role\Store  $request
     * @param  \App\Models\Role      $role 用户组模型
     * @return \Illuminate\Http\Response
     */
    public function update(Store $request, Role $role)
    {
        $data=$request->except('_token');
        $map = [
            'id'=>$data['id']
        ];
        $role->editData($map, $data);
        return redirect('admin/role/index');
    }

    /**
     * 删除用户组
     *
     * @param  \App\Models\Role       $role 用户组模型
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $id=request()->input('id');
        $map=[
            'id'=>$id
        ];
        $role->deleteData($map);
        return redirect('admin/role/index');
    }

    /**
     * 分配权限页面
     *
     * @param  \App\Models\Role         $role 用户组模型
     * @param  \App\Models\Permission        $permission  权限模型
     * @return \Illuminate\Http\Response
     */
    public function rule_group_show(Role $role, Permission $permission)
    {
        $id=request()->input('id');
        //获取用户组数据
        $group_data=$role::find($id)->toArray();
        $group_data['rules']=explode(',', $group_data['rules']);
        //获取全部权限
        $rule_data=$permission->getTreeData('level', 'id');
        $assign=[
            'group_data'=>$group_data,
            'rule_data'=>$rule_data
        ];
        return view('admin/role/rule_group_show', $assign);
    }

    /**
     * 保存分配的权限
     *
     * @param  \App\Http\Requests\Role\Store  $request
     * @param  \App\Models\Role      $role 用户组模型
     * @return \Illuminate\Http\Response
     */
    public function rule_group_update(Store $request, Role $role)
    {
        $data=$request->except('_token');
        $data['rules']=implode(',', $data['rules']);
        $map = [
            'id'=>$data['id']
        ];
        $role->editData($map, $data);
        return redirect()->back();
    }


}
