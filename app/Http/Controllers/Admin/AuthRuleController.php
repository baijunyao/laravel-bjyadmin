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
        return view('admin/auth_rule/index', $assign);
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
        $data=$request->except('_token');
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
        $data=$request->except('_token');
        $map=[
            'id'=>$data['id']
        ];
        $authRule->editData($map, $data);
        return redirect('admin/auth_rule/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\AuthRule       $authRule 权限模型
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthRule $authRule)
    {
        $id=request()->input('id');
        $map=[
            'id'=>$id
        ];
        $authRule->deleteData($map);
        return redirect('admin/auth_rule/index');
    }
    

}
