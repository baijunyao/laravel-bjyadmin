@extends('layouts.admin')

@section('title', '用户列表')

@section('nav', '用户列表')

@section('description', '注册的用户列表')


@section('content')

    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th width="10%">用户名</th>
        </tr>
        @foreach($data as $v)
            <tr>
                <td>{{ $v->name }}</td>

            </tr>
        @endforeach
    </table>
    {{ $data->links() }}
@endsection

