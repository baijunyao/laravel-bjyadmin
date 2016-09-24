<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\AuthRule;

class AuthRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Model\AuthRule       $authRule 权限模型
     * @return \Illuminate\Http\Response
     */
    public function index(AuthRule $authRule)
    {
        $data=$authRule->getTreeData('tree','id');
        $assign=[
            'data'=>$data
        ];
        return View('admin/auth_rule/index', $assign);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AuthRule       $authRule 权限模型
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AuthRule $authRule)
    {
        $data=$request->all();
        $authRule->addData($data);
        return redirect('admin/auth_rule/index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AuthRule       $authRule 权限模型
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuthRule $authRule)
    {
        $data=$request->all();
        $authRule->editData($data);
        return redirect('admin/auth_rule/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\AuthRule       $authRule 权限模型
     * @param  int                       $id       权限id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthRule $authRule, $id)
    {
        $authRule->deleteData($id);
        return redirect('admin/auth_rule/index');
    }
    

}
