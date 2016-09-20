<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\AuthGroup;

class AuthGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Model\AuthGroup       $authGroup 用户组模型
     * @return \Illuminate\Http\Response
     */
    public function index(AuthGroup $authGroup)
    {
        $data=$authGroup->getTreeData('tree','id');
        $assign=[
            'data'=>$data
        ];
        return View('admin.auth_rule.index', $assign);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AuthGroup       $authGroup 用户组模型
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AuthGroup $authGroup)
    {
        $data=$request->all();
        $authGroup->addData($data);
        return redirect('admin/auth_rule/index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AuthGroup       $authGroup 用户组模型
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuthGroup $authGroup)
    {
        $data=$request->all();
        $authGroup->editData($data);
        return redirect('admin/auth_rule/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\AuthGroup       $authGroup 用户组模型
     * @param  int                       $id       权限id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthGroup $authGroup, $id)
    {
        $authGroup->deleteData($id);
        return redirect('admin/auth_rule/index');
    }


}
