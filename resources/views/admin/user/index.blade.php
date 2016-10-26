@extends('layouts.admin')

@section('title', '用户列表')

@section('nav', '用户列表')

@section('description', '注册的用户列表')


@section('content')

    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th width="10%">用户名</th>
            <th width="10%">邮箱</th>
            <th width="10%">手机号</th>
            <th width="10%">状态</th>
            <th width="10%">注册时间</th>
        </tr>
        @foreach($data as $v)
            <tr>
                <td>{{ $v->name }}</td>
                <td>{{ $v->email }}</td>
                <td>{{ $v->phone }}</td>
                <td>{{ $v->status }}</td>
                <td>{{ $v->created_at }}</td>
            </tr>
        @endforeach
    </table>
    <div class="text-center">
        {{ $data->links() }}
    </div>
@endsection

