<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Permission       $authRule 权限模型
     * @return \Illuminate\Http\Response
     */
    public function index(Permission $authRule)
    {
        $data=$authRule->getTreeData('tree','id');
        $assign=[
            'data'=>$data
        ];
        return view('admin/permissions/index', $assign);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission       $authRule 权限模型
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Permission $authRule)
    {
        $data=$request->except('_token');
        $authRule->addData($data);
        return redirect('admin/permissions/index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission       $authRule 权限模型
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $authRule)
    {
        $data=$request->except('_token');
        $map=[
            'id'=>$data['id']
        ];
        $authRule->editData($map, $data);
        return redirect('admin/permissions/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission       $authRule 权限模型
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $authRule)
    {
        $id=request()->input('id');
        $map=[
            'id'=>$id
        ];
        $authRule->deleteData($map);
        return redirect('admin/permissions/index');
    }
    

}
