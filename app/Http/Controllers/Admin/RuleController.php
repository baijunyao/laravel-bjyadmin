<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\AuthRule;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AuthRule $authRule)
    {
        $data=$authRule->getTreeData('tree','id');
        $assign=[
            'data'=>$data
        ];
        return View('admin.rule.index', $assign);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AuthRule       $AuthRule 权限模型
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AuthRule $AuthRule)
    {
        $data=$request->all();
        $AuthRule->addData($data);
        return redirect('admin/rule/index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AuthRule       $AuthRule 权限模型
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuthRule $AuthRule)
    {
        $data=$request->all();
        $AuthRule->editData($data);
        return redirect('admin/rule/index');
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
