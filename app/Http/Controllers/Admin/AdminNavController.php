<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\AdminNav;

class AdminNavController extends Controller
{

    /**
     * 菜单管理页面
     *
     * @param  \App\Model\AdminNav        $adminNav 后台菜单模型
     * @return \Illuminate\Http\Response
     */
    public function index(AdminNav $adminNav)
    {
        $data=$adminNav->getTreeData('tree','order_number,id');
        $assign=[
            'data'=>$data
        ];
        return view('admin/admin_nav/index',$assign);
    }

    /**
     * 添加菜单
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AdminNav        $adminNav 后台菜单模型
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,AdminNav $adminNav)
    {
        $data=$request->except('_token');
        $adminNav->addData($data);
        return redirect('admin/admin_nav/index');
    }

    /**
     * 修改菜单
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AdminNav        $adminNav 后台菜单模型
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request ,AdminNav $adminNav)
    {
        //获取post数据
        $data=$request->except('_token');
        $map=[
            'id'=>$data['id']
        ];
        $adminNav->editData($map, $data);
        return redirect('admin/admin_nav/index');
    }

    /**
     * 删除菜单
     *
     * @param  \App\Model\AdminNav        $adminNav 后台菜单模型
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminNav $adminNav, $id)
    {
        $map=[
            'id'=>$id
        ];
        $adminNav->deleteData($map);
        return redirect('admin/admin_nav/index');
    }

    /**
     * 排序
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AdminNav        $adminNav 后台菜单模型
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request, AdminNav $adminNav){
        $data=$request->except('_token');
        $adminNav->orderData($data);
        return redirect('admin/admin_nav/index');
    }

}
