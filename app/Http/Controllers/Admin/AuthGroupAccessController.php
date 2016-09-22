<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\AuthGroupAccess;
use App\Model\AuthGroup;
use App\Model\User;

class AuthGroupAccessController extends Controller
{

    /**
     * 添加用户到用户组的页面 用户组列表 > 添加用户到用户组
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
