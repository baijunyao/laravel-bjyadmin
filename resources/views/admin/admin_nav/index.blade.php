@extends('layouts.admin')

@section('title', '菜单管理')

@section('nav', '菜单管理')

@section('description', '对菜单的一些操作')

@section('content')

    <div class="x_panel">
        <ul id="myTab" class="nav nav-tabs bar_tabs">
            <li class="active">
                <a href="#home" data-toggle="tab">菜单列表</a>
            </li>
            <li>
                <a href="javascript:;" onclick="add()">添加菜单</a>
            </li>
        </ul>

        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="home">
                <form action="{{url('admin/admin_nav/order')}}" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <table class="table table-striped table-bordered table-hover">
                                <tr>
                                    <th width="5%">排序</th>
                                    <th>菜单名</th>
                                    <th>连接</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($data as $k=>$v)
                                    <tr>
                                        <td>
                                            <input class="form-control" style="width:40px;height:25px;" type="text" name="{{$v['id']}}" value="{{$v['order_number']}}">
                                        </td>
                                        <td>{{$v['_name']}}</td>
                                        <td>{{$v['mca']}}</td>
                                        <td>
                                            <a href="javascript:;" navId="{{$v['id']}}" navName="{{$v['name']}}"  onclick="add_child(this)">添加子菜单</a> |
                                            <a href="javascript:;" navId="{{$v['id']}}" navName="{{$v['name']}}" navMca="{{$v['mca']}}" navIco="{{$v['ico']}}" onclick="edit(this)">修改</a> |
                                            <a href="javascript:if(confirm('确定删除？'))location='{{url('admin/admin_nav/destroy'.'?id='.$v['id'])}}'">删除</a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>
                                        <input class="btn btn-success" type="submit" value="排序">
                                    </th>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                </form>
            </div>
        </div>
    </div>
    <!-- 添加菜单模态框开始 -->
    <div class="modal fade" id="bjy-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        添加菜单
                    </h4>
                </div>
                <div class="modal-body">
                    <form id="bjy-form" class="form-inline" action="{{url('admin/admin_nav/store')}}" method="post">
                        <input type="hidden" name="pid" value="0">
                        {{ csrf_field() }}
                        <table class="table table-striped table-bordered table-hover">
                            <tr>
                                <th width="16%">菜单名：</th>
                                <td>
                                    <input class="form-control" type="text" name="name">
                                </td>
                            </tr>
                            <tr>
                                <th>连接：</th>
                                <td>
                                    <input class="form-control" type="text" name="mca"> 输入模块/控制器/方法即可 例如 Admin/Nav/index
                                </td>
                            </tr>
                            <tr>
                                <th>图标：</th>
                                <td>
                                    <input class="form-control" type="text" name="ico">
                                    font-awesome图标 输入fa fa- 后边的即可
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-success" type="submit" value="添加">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 添加菜单模态框结束 -->

    <!-- 修改菜单模态框开始 -->
    <div class="modal fade" id="bjy-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        修改菜单
                    </h4>
                </div>
                <div class="modal-body">
                    <form id="bjy-form" class="form-inline" action="{{url('admin/admin_nav/update')}}" method="post">
                        <input type="hidden" name="id">
                        {{ csrf_field() }}
                        <table class="table table-striped table-bordered table-hover">
                            <tr>
                                <th width="16%">菜单名：</th>
                                <td>
                                    <input class="form-control" type="text" name="name">
                                </td>
                            </tr>
                            <tr>
                                <th>连接：</th>
                                <td>
                                    <input class="form-control" type="text" name="mca"> 输入模块/控制器/方法即可 例如 Admin/Nav/index
                                </td>
                            </tr>
                            <tr>
                                <th>图标：</th>
                                <td>
                                    <input class="form-control" type="text" name="ico">
                                    font-awesome图标 输入fa fa- 后边的即可
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-success" type="submit" value="修改">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 修改菜单模态框结束 -->
@endsection

@section('js')

    <script>
        // 添加菜单
        function add(){
            $("input[name='name'],input[name='mca']").val('');
            $("input[name='pid']").val(0);
            $('#bjy-add').modal('show');
        }

        // 添加子菜单
        function add_child(obj){
            var navId=$(obj).attr('navId');
            $("input[name='pid']").val(navId);
            $("input[name='name']").val('');
            $("input[name='mca']").val('');
            $("input[name='ico']").val('');
            $('#bjy-add').modal('show');
        }

        // 修改菜单
        function edit(obj){
            var navId=$(obj).attr('navId');
            var navName=$(obj).attr('navName');
            var navMca=$(obj).attr('navMca');
            var navIco=$(obj).attr('navIco');
            $("input[name='id']").val(navId);
            $("input[name='name']").val(navName);
            $("input[name='mca']").val(navMca);
            $("input[name='ico']").val(navIco);
            $('#bjy-edit').modal('show');
        }

    </script>

@endsection

