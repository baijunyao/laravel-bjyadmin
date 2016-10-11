<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\AuthGroup;
use App\Model\AuthRule;

class AuthGroupController extends Controller
{
    /**
     * 用户组列表
     *
     * @param  \App\Model\AuthGroup       $authGroup 用户组模型
     * @return \Illuminate\Http\Response
     */
    public function index(AuthGroup $authGroup)
    {
        $data=$authGroup::all()->toArray();
        $assign=[
            'data'=>$data
        ];
        return view('admin/auth_group/index', $assign);
    }

    /**
     * 添加用户组
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AuthGroup      $authGroup 用户组模型
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AuthGroup $authGroup)
    {
        $data=$request->except('_token');
        $authGroup->addData($data);
        return redirect('admin/auth_group/index');
    }


    /**
     * 修改用户组
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AuthGroup      $authGroup 用户组模型
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuthGroup $authGroup)
    {
        $data=$request->except('_token');
        $map = [
            'id'=>$data['id']
        ];
        $authGroup->editData($map, $data);
        return redirect('admin/auth_group/index');
    }

    /**
     * 删除用户组
     *
     * @param  \App\Model\AuthGroup       $authGroup 用户组模型
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthGroup $authGroup)
    {
        $id=request()->input('id');
        $map=[
            'id'=>$id
        ];
        $authGroup->deleteData($map);
        return redirect('admin/auth_group/index');
    }

    /**
     * 分配权限页面
     *
     * @param  \App\Model\AuthGroup       $authGroup 用户组模型
     * @param  \App\Model\AuthRule        $authRule  权限模型
     * @param  int                        $id        用户组id
     * @return \Illuminate\Http\Response
     */
    public function rule_group_show(AuthGroup $authGroup, AuthRule $authRule, $id)
    {
        //获取用户组数据
        $group_data=$authGroup::find($id)->toArray();
        $group_data['rules']=explode(',', $group_data['rules']);
        //获取全部权限
        $rule_data=$authRule->getTreeData('level', 'id');
        $assign=[
            'group_data'=>$group_data,
            'rule_data'=>$rule_data
        ];
        return view('admin/auth_group/rule_group_show', $assign);
    }

    /**
     * 保存分配的权限
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AuthGroup      $authGroup 用户组模型
     * @return \Illuminate\Http\Response
     */
    public function rule_group_update(Request $request, AuthGroup $authGroup)
    {
        $data=$request->except('_token');
        $data['rules']=implode(',', $data['rules']);
        $map = [
            'id'=>$data['id']
        ];
        $authGroup->editData($map, $data);
        return redirect()->back();
    }


}
