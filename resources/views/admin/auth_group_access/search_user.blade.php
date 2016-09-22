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
                    <input class="form-control" type="text" name="username" value="{{ $username }}">
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
        <foreach name="user_data" item="v">
        @foreach($user_data as $v)
            <tr>
                <th>{{ $v['username'] }}</th>
                <td>
                    @if(in_array($v['id'],$group_uid))
                        已经是{{ $group_title }}
                    @else
                        <a href="{:U('Admin/Rule/add_user_to_group',array('uid'=>$v['id'],'group_id'=>$_GET['group_id'],'username'=>$_GET['username']))}">设为{{ $group_title }}</a>
                    @endif
                </td>
            </tr>
        @endforeach

    </table>

@endsection