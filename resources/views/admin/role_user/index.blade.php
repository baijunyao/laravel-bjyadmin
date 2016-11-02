@extends('layouts.admin')

@section('title', '管理员列表')

@section('nav', '管理员列表')

@section('description', '对管理员的操作')

@section('content')

    <ul id="myTab" class="nav nav-tabs bar_tabs">
        <li class="active">
            <a href="{{ url('admin/role_user/index') }}">管理员列表</a>
        </li>
        <li>
            <a href="{{ url('admin/role_user/create') }}">添加管理员</a>
        </li>
    </ul>
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th width="10%">用户名</th>
            <th>角色</th>
            <th>操作</th>
        </tr>
        @foreach($data as $v)
            <tr>
                <td>{{ $v['name'] }}</td>
                <td>{{ $v['display_name'] }}</td>
                <td>
                    <a href="{{ url('admin/role_user/edit').'?id='.$v['id'] }}">修改权限或密码</a>
                </td>
            </tr>
        @endforeach
    </table>

@endsection
