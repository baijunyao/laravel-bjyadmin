@extends('admin.public.master')

@section('title', '添加用户到用户组')

@section('nav', '用户组列表 > 添加用户到用户组')

@section('body')

    <table class="table table-striped table-bordered table-hover table-condensed">
        <tr>
            <th width="10%">
                搜索用户名：
            </th>
            <td>
                <form class="form-inline" action="">
                    <input type="hidden" name="group_id" value="{{ $group_id }}">
                    <input class="form-control" type="text" name="name" value="{{ $name }}">
                    <input class="btn btn-success" type="submit" value="搜索">
                </form>
            </td>
        </tr>
    </table>
    <table class="table table-striped table-bordered table-hover table-condensed">
        <tr>
            <th width="10%">用户名</th>
            <th>操作</th>
        </tr>
        @foreach($user_data as $v)
            <tr>
                <th>{{ $v['name'] }}</th>
                <td>
                    @if(in_array($v['id'],$group_uid))
                        已经是{{ $group_title }}
                        <a href="{{ url('admin/auth_group_access/delete_user_from_group',['uid'=>$v['id'],'group_id'=>$group_id]) }}">取消管理员权限</a>
                    @else
                        <a href="{{ url('admin/auth_group_access/add_user_to_group').'?uid='.$v['id'].'&group_id='.$group_id }}">设为{{ $group_title }}</a>
                    @endif
                </td>
            </tr>
        @endforeach

    </table>

@endsection