<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use App\Http\Requests\User\Store;
use App\Http\Requests\User\Update;
use App\Http\Controllers\Controller;

class RoleUserController extends Controller
{

    /**
     * 管理员列表
     *
     * @param  \App\Models\RoleUser $roleUser
     * @return \Illuminate\Http\Response
     */
    public function index(RoleUser $roleUser)
    {
        $data=$roleUser->getAdminUserList();
        $assign=[
            'data'=>$data
        ];
        return view('admin/role_user/index',$assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function create(Role $role)
    {
        $data=$role::all()->toArray();
        $assign=[
            'data'=>$data
        ];
        return view('admin/role_user/create', $assign);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Requests\User\Store  $request
     * @param  \App\Models\User $user
     * @param  \App\Models\RoleUser $roleUser
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request, User $user, RoleUser $roleUser)
    {
        $data=$request->except('_token');
        $user_data=[
            'name'=>$data['name'],
            'phone'=>$data['phone'],
            'email'=>$data['email'],
            'password'=>$data['password'],
            'status'=>$data['status']
        ];
        $user_id=$user->addData($user_data);
        if($user_id){
            if (!empty($data['role_ids'])) {
                foreach ($data['role_ids'] as $k => $v) {
                    $roleUserData=array(
                        'user_id'=>$user_id,
                        'role_id'=>$v
                    );
                    $roleUser->addData($roleUserData);
                }
            }
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //获取用户id
        $user_id = request()->input('id');
        // 获取用户数据
        $user_data=User::find($user_id)->toArray();
        // 获取已加入角色
        $role_ids=RoleUser::where('user_id', $user_id)
            ->pluck('role_id')
            ->toArray();
        // 全部角色
        $role_data=Role::all()->toArray();
        $assign=[
            'user_data'=>$user_data,
            'role_data'=>$role_data,
            'role_ids'=>$role_ids,
        ];
        return view('admin/role_user/edit', $assign);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\User\Update   $request
     * @param  \App\Models\RoleUser             $roleUser
     * @param  \App\Models\User                 $user
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, RoleUser $roleUser, User $user)
    {
        $data=$request->except('_token');
        // 组合where数组条件
        $user_id=$data['user_id'];
        $delete_map=[
            'user_id'=>$user_id
        ];
        //先删除已有的权限
        $roleUser->deleteData($delete_map);
        //再添加权限
        foreach ($data['role_ids'] as $k => $v) {
            $roleUserData=array(
                'user_id'=>$user_id,
                'role_id'=>$v
            );
            $roleUser->addData($roleUserData);
        }
        //如果密码为空；则删除字段
        if (empty($data['password'])) {
            unset($data['password']);
        }
        //删除id和role_id
        unset($data['user_id'], $data['role_ids']);
        $user_map=array(
            'id'=>$user_id
        );
        $user->editData($user_map,$data);
        return redirect()->back();
    }

    /**
     * 添加用户到角色的页面 搜索用户
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search_user(Request $request)
    {
        $role_id=request()->input('role_id');
        //获取搜索的用户名
        $name=$request->input('name');
        //根据用户名查找user表中的用户
        if (empty($name)) {
            $user_data=[];
        }else{
            $user_data=User::where('name','like',"%$name%")
                ->select('id','name')
                ->get()
                ->toArray();
        }
        //根据角色id 获取角色名
        $role_display_name=Role::where('id', $role_id)->value('display_name');
        $user_ids=RoleUser::where('role_id', $role_id)
            ->pluck('user_id')
            ->toArray();
        $assign=[
            'role_id'=>$role_id,
            'role_display_name'=>$role_display_name,
            'user_ids'=>$user_ids,
            'name'=>$name,
            'user_data'=>$user_data
        ];
        return view('admin/role_user/search_user', $assign);
    }

    /**
     * @param \App\Models\RoleUser $roleUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add_user_to_group(RoleUser $roleUser)
    {
        $user_id=request()->input('user_id');
        $role_id=request()->input('role_id');
        $data=[
            'user_id'=>$user_id,
            'role_id'=>$role_id
        ];
        $roleUser->addData($data);
        return redirect()->back();
    }

    /**
     * @param \App\Models\RoleUser $roleUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_user_from_group(RoleUser $roleUser)
    {
        $user_id=request()->input('user_id');
        $role_id=request()->input('role_id');
        $map=[
            'user_id'=>$user_id,
            'role_id'=>$role_id
        ];
        $roleUser->deleteData($map);
        return redirect()->back();
    }

}
