<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdminNav;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Model\AdminNav $adminNav
     * @return \Illuminate\Http\Response
     */
    public function index(AdminNav $adminNav)
    {
        //获取菜单
        $nav_data=$adminNav->getTreeData('level','order_number,id');
        $assign=[
            'nav_data'=>$nav_data
        ];
        return view('admin/index/index', $assign);
    }

    /**
     * 欢迎页面
     */
    public function welcome()
    {
        echo '欢迎页面';
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
