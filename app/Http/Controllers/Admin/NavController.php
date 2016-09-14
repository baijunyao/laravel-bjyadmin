<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\AdminNav;

class NavController extends Controller
{

    /**
     * 菜单管理页面
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdminNav $adminNav)
    {
        $data=$adminNav->getTreeData('tree','order_number,id');
        $assign=[
            'data'=>$data
        ];
        return View('admin.nav.index',$assign);
    }

    /**
     * 添加菜单
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,AdminNav $adminNav)
    {
        $data=$request->all();
        $adminNav->addData($data);
        return redirect('admin/nav/index');
    }

    /**
     * 修改菜单
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo $id;
    }

    /**
     * 删除菜单
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        p($_GET);die;
    }

    /**
     * 排序
     *
     * @return \Illuminate\Http\Response
     */
    public function order(){


    }

}
