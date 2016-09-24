<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Crypt;
use Hash;
use DB;

use App\Model\AuthGroupAccess;
use App\Model\AuthGroup;
use App\Model\User;

class AuthGroupAccessController extends Controller
{

    /**
     * 管理员列表
     *
     * @param  \App\Model\AuthGroupAccess $authGroupAccess
     * @return \Illuminate\Http\Response
     */
    public function index(AuthGroupAccess $authGroupAccess)
    {
        $data=$authGroupAccess->getAdminUserList();
        $assign=[
            'data'=>$data
        ];
        return View('admin/auth_group_access/index',$assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Model\AuthGroup $authGroup
     * @return \Illuminate\Http\Response
     */
    public function create(AuthGroup $authGroup)
    {
        $data=$authGroup::all()->toArray();
        $assign=[
            'data'=>$data
        ];
        return View('admin/auth_group_access/create', $assign);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\User $user
     * @param  \App\Model\AuthGroupAccess $authGroupAccess
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, AuthGroupAccess $authGroupAccess)
    {
        $data=$request->except('_token');
        $user_data=[
            'username'=>$data['username'],
            'phone'=>$data['phone'],
            'email'=>$data['email'],
            'password'=>$data['password'],
            'status'=>$data['status']
        ];
        $uid=$user->addData($user_data);
        if($uid){
            if (!empty($data['group_ids'])) {
                foreach ($data['group_ids'] as $k => $v) {
                    $group=array(
                        'uid'=>$uid,
                        'group_id'=>$v
                    );
                    $authGroupAccess->addData($group);
                }
            }
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $uid
     * @return \Illuminate\Http\Response
     */
    public function edit($uid)
    {
        // 获取用户数据
        $user_data=User::find($uid)->toArray();
        // 获取已加入用户组
        $group_access_data=AuthGroupAccess::where('uid', $uid)
            ->lists('group_id')
            ->toArray();
        // 全部用户组
        $group_data=AuthGroup::all()->toArray();
        $assign=[
            'user_data'=>$user_data,
            'group_data'=>$group_data,
            'group_access_data'=>$group_access_data,
        ];
        return View('admin/auth_group_access/edit', $assign);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuthGroupAccess $authGroupAccess, User $user)
    {
        $data=$request->except('_token');
        // 组合where数组条件
        $uid=$data['id'];
        $map=array(
            'id'=>$uid
        );
        //先删除已有的权限
        $authGroupAccess->deleteData($uid);
        //再添加权限
        foreach ($data['group_ids'] as $k => $v) {
            $group=array(
                'uid'=>$uid,
                'group_id'=>$v
            );
            $authGroupAccess->addData($group);
        }
        //如果密码为空；则删除字段
        if (empty($data['password'])) {
            unset($data['password']);
        }
        //删除id和group_id
        unset($data['id'], $data['group_ids']);
        $user->editData($map,$data);
        return redirect()->back();
    }

    /**
     * 添加用户到用户组的页面 搜索学生
     *
     * @param  int  $group_id
     * @param  \App\Model\AuthGroup $authGroup
     * @param  \App\Model\AuthGroupAccess $authGroupAccess
     * @param  \App\Model\User $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search_user(AuthGroup $authGroup, AuthGroupAccess $authGroupAccess, User $user, Request $request, $group_id)
    {
        //获取搜索的用户名
        $username=$request->input('username');
        //根据用户名查找user表中的用户
        if (empty($username)) {
            $user_data='';
        }else{
            $user_data=$user::where('username','like',"%$username%")
                ->select('id','username')
                ->get()
                ->toArray();
        }
        //根据用户组id 获取用户组名
        $group_title=$authGroup::where('id', $group_id)->pluck('title');
        $group_uid=$authGroupAccess::where('group_id', $group_id)
            ->lists('uid')
            ->toArray();
        $assign=[
            'group_id'=>$group_id,
            'group_title'=>$group_title,
            'group_uid'=>$group_uid,
            'username'=>$username,
            'user_data'=>$user_data
        ];
        return View('admin/auth_group_access/search_user', $assign);
    }

    /**
     * @param \App\Model\AuthGroupAccess $authGroupAccess
     * @param $uid
     * @param $group_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add_user_to_group(AuthGroupAccess $authGroupAccess, $uid, $group_id)
    {
        $data=[
            'uid'=>$uid,
            'group_id'=>$group_id
        ];
        $authGroupAccess->addData($data);
        return redirect()->back();
    }

    /**
     * @param \App\Model\AuthGroupAccess $authGroupAccess
     * @param $uid
     * @param $group_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_user_from_group(AuthGroupAccess $authGroupAccess, $uid, $group_id)
    {
        $data=[
            'uid'=>$uid,
            'group_id'=>$group_id
        ];
        $authGroupAccess->deleteData($data);
        return redirect()->back();
    }

}
