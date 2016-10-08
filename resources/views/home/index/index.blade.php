@extends('public.bootstrap')


@section('title', '首页')


@section('body')

    <a href="{{ url('user/phone_register/index') }}">手机注册</a> <br>
    <br>
    <a href="">后台登录</a> <br>

@endsection