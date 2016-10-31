<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Http\Requests;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\PermissionRole;
use App\Http\Requests\Role\Store;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * 角色列表
     *
     * @param  \App\Models\Role       $role 角色模型
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
     * 添加角色
     *
     * @param  \App\Http\Requests\Role\Store  $request
     * @param  \App\Models\Role      $role 角色模型
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request, Role $role)
    {
        $data=$request->except('_token');
        p($data);
        $role->addData($data);
        return redirect()->back();
    }


    /**
     * 修改角色
     *
     * @param  \App\Http\Requests\Role\Store  $request
     * @param  \App\Models\Role      $role 角色模型
     * @return \Illuminate\Http\Response
     */
    public function update(Store $request, Role $role)
    {
        $data=$request->except('_token');
        $map = [
            'id'=>$data['id']
        ];
        $role->editData($map, $data);
        return redirect()->back();
    }

    /**
     * 删除角色
     *
     * @param  \App\Models\Role       $role 角色模型
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $id=request()->input('id');
        $map=[
            'id'=>$id
        ];
        $role->deleteData($map);
        return redirect()->back();
    }

    /**
     * 分配权限页面
     *
     * @param  \App\Models\Role         $role 角色模型
     * @param  \App\Models\Permission        $permission  权限模型
     * @param  \App\Models\PermissionRole        $permissionRole  权限模型
     * @return \Illuminate\Http\Response
     */
    public function permission_role_show(Role $role, Permission $permission, PermissionRole $permissionRole)
    {
        $id=request()->input('id');
        //获取角色数据
        $role=$role::find($id)->toArray();
        $has_permission_ids = PermissionRole::where('role_id', $id)->pluck('permission_id')->toArray();
        //获取全部权限
        $permission = $permission->getTreeData('level', 'id');
        $assign=[
            'role'=>$role,
            'permission'=>$permission,
            'has_permission_ids'=>$has_permission_ids
        ];
        return view('admin/role/permission_role_show', $assign);
    }

    /**
     * 保存分配的权限
     *
     * @param  \Illuminate\Http\Request             $request
     * @param  \App\Models\PermissionRole           $permissionRole 角色模型
     * @return \Illuminate\Http\Response
     */
    public function permission_role_update(Request $request, PermissionRole $permissionRole)
    {
        $data=$request->except('_token');
        //清空此用户原来的权限
        $map=[
            'role_id'=>$data['id']
        ];
        $permissionRole->deleteData($map);
        //重新添加权限
        foreach ($data['permission_ids'] as $v) {
            $addData=[
                'permission_id'=>$v,
                'role_id'=>$data['id']
            ];
            $permissionRole->addData($addData);
        }
        return redirect()->back();
    }


}
