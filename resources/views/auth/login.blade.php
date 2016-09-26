@extends('public.bootstrap')

@section('title', '登录')


@section('body')

    <form method="POST" action="/auth/login">
        {!! csrf_field() !!}

        <div>
            Email
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            密码
            <input type="password" name="password" id="password">
        </div>

        <div>
            <input type="checkbox" name="remember"> 记住我
        </div>

        <div>
            <button type="submit">登录</button>
        </div>
    </form>

@endsection