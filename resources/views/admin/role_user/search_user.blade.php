@extends('layouts.admin')

@section('title', '添加用户到角色')

@section('nav', '角色列表')

@section('description', '设置管理员或者取消管理员')

@section('content')

    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th width="10%">
                搜索用户名：
            </th>
            <td>
                <form class="form-inline" action="">
                    <input type="hidden" name="role_id" value="{{ $role_id }}">
                    <input class="form-control" type="text" name="name" value="{{ $name }}">
                    <input class="btn btn-success" type="submit" value="搜索">
                </form>
            </td>
        </tr>
    </table>
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th width="10%">用户名</th>
            <th>操作</th>
        </tr>
        @foreach($user_data as $v)
            <tr>
                <th>{{ $v['name'] }}</th>
                <td>
                    @if(in_array($v['id'],$user_ids))
                        已经是{{ $role_display_name }}
                        <a href="{{ url('admin/role_user/delete_user_from_group').'?user_id='.$v['id'].'&role_id='.$role_id }}">取消管理员权限</a>
                    @else
                        <a href="{{ url('admin/role_user/add_user_to_group').'?user_id='.$v['id'].'&role_id='.$role_id }}">设为{{ $role_display_name }}</a>
                    @endif
                </td>
            </tr>
        @endforeach

    </table>

@endsection