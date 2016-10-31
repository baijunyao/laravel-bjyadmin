@extends('layouts.admin')

@section('title', '角色管理')

@section('nav', '角色管理')

@section('description', '对角色的一些操作')

@section('content')

    <div class="x_panel">
        <ul id="myTab" class="nav nav-tabs bar_tabs">
            <li class="active">
                <a href="#home" data-toggle="tab">角色列表</a>
            </li>
            <li>
                <a href="javascript:;" onclick="add()">添加角色</a>
            </li>
        </ul>

        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="home">
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>角色名</th>
                        <th>角色</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td>{{ $v['display_name'] }}</td>
                            <td>{{ $v['name'] }}</td>
                            <td>
                                <a href="javascript:;" ruleId="{{ $v['id'] }}" ruleName="{{ $v['name'] }}" ruleDisplayName="{{ $v['display_name'] }}" onclick="edit(this)">修改</a> |
                                <a href="javascript:if(confirm('确定删除？'))location='{{ url('admin/role/destroy').'?id='.$v['id'] }}'">删除</a> |
                                <a href="{{ url('admin/role/permission_role_show').'?id='.$v['id'] }}">分配权限</a> |
                                <a href="{{ url('admin/role_user/search_user').'?role_id='.$v['id'] }}">添加成员</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <!-- 添加角色模态框开始 -->
    <div class="modal fade" id="bjy-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        添加角色
                    </h4>
                </div>
                <div class="modal-body">
                    <form id="bjy-form" class="form-inline" action="{{ url('admin/role/store') }}" method="post">
                        {{ csrf_field() }}
                        <table class="table table-striped table-bordered table-hover">
                            <tr>
                                <th width="16%">角色名：</th>
                                <td>
                                    <input class="form-control" type="text" name="display_name">
                                </td>
                            </tr>
                            <tr>
                                <th>角色：</th>
                                <td>
                                    <input class="form-control" type="text" name="name">
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
    <!-- 添加角色模态框结束 -->

    <!-- 修改角色模态框开始 -->
    <div class="modal fade" id="bjy-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        修改角色
                    </h4>
                </div>
                <div class="modal-body">
                    <form id="bjy-form" class="form-inline" action="{{ url('admin/role/update') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id">
                        <table class="table table-striped table-bordered table-hover">
                            <tr>
                                <th width="16%">角色名：</th>
                                <td>
                                    <input class="form-control" type="text" name="display_name">
                                </td>
                            </tr>
                            <tr>
                                <th>角色：</th>
                                <td>
                                    <input class="form-control" type="text" name="name">
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
    <!-- 修改角色模态框结束 -->

@endsection

@section('js')

    <script>
        // 添加角色
        function add(){
            $("input[name='name']").val('');
            $("input[name='display_name']").val('');
            $('#bjy-add').modal('show');
        }

        // 修改角色
        function edit(obj){
            var ruleId=$(obj).attr('ruleId');
            var ruleName=$(obj).attr('ruleName');
            var ruleDisplayName=$(obj).attr('ruleDisplayName');
            $("input[name='id']").val(ruleId);
            $("input[name='name']").val(ruleName);
            $("input[name='display_name']").val(ruleDisplayName);
            $('#bjy-edit').modal('show');
        }
    </script>

@endsection