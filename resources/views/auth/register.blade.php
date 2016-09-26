@extends('public.bootstrap')

@section('title', '注册')


@section('body')

    <form method="POST" action="/auth/register">
        {!! csrf_field() !!}

        <div>
            用户名
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div>
            Email
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            密码
            <input type="password" name="password">
        </div>

        <div>
            确认密码
            <input type="password" name="password_confirmation">
        </div>

        <div>
            <button type="submit">注册</button>
        </div>
    </form>

@endsection