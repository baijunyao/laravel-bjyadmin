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
        return View('admin/admin_nav/index',$assign);
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
        $data=$request->all();
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
        $data=$request->all();
        $adminNav->editData($data);
        return redirect('admin/admin_nav/index');
    }

    /**
     * 删除菜单
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminNav $adminNav, $id)
    {
        $adminNav->deleteData($id);
        return redirect('admin/admin_nav/index');
    }

    /**
     * 排序
     *
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request, AdminNav $adminNav){
        $data=$request->all();
        $adminNav->orderData($data);
        return redirect('admin/admin_nav/index');
    }

}
