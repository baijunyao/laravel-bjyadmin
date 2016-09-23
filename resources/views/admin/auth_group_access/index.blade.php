@extends('admin.public.master')

@section('title', '管理员列表')

@section('nav', '权限管理 > 管理员列表')

@section('body')

    <ul id="myTab" class="nav nav-tabs">
        <li class="active">
            <a href="{{ url('admin/auth_group_access/index') }}">管理员列表</a>
        </li>
        <li>
            <a href="{{ url('admin/auth_group_access/create') }}">添加管理员</a>
        </li>
    </ul>
    <table class="table table-striped table-bordered table-hover table-condensed">
        <tr>
            <th width="10%">用户名</th>
            <th>用户组</th>
            <th>操作</th>
        </tr>
        @foreach($data as $v)
            <tr>
                <td>{{ $v['username'] }}</td>
                <td>{{ $v['title'] }}</td>
                <td>
                    <a href="{{ url('admin/auth_group_access/edit',['id'=>$v['id']]) }}">修改权限或密码</a>
                </td>
            </tr>
        @endforeach
    </table>

@endsection
