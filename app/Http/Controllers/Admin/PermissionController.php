<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\Store;

class PermissionController extends Controller
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
        return view('admin/permission/index', $assign);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Permission\Store      $request
     * @param  \App\Models\Permission                   $authRule 权限模型
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request, Permission $authRule)
    {
        $data=$request->except('_token');
        $authRule->addData($data);
        return redirect('admin/permission/index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Permission\Store  $request
     * @param  \App\Models\Permission       $authRule 权限模型
     * @return \Illuminate\Http\Response
     */
    public function update(Store $request, Permission $authRule)
    {
        $data=$request->except('_token');
        $map=[
            'id'=>$data['id']
        ];
        $authRule->editData($map, $data);
        return redirect('admin/permission/index');
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
        return redirect('admin/permission/index');
    }
    

}
