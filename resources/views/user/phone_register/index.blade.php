@extends('public.bootstrap')

@section('title', '手机注册')

@section('body')

    <form action="{{ url('user/phone_register/store') }}" method="post">
        {{ csrf_field() }}
        手机号：<input type="text" name="phone"> <br>
        验证码：<input type="text" name="code">
        <a href="javascript:;" onclick="sendCode()">获取验证码</a>
        <br>
        用户名：<input type="text" name="name"> <br>
        密码：<input type="text" name="password"> <br>
        <input type="submit" value="注册">
    </form>

@endsection


@section('js')
    <script>
        var get_code='{{ url('user/phone_register/get_code') }}';
    </script>
    <script src="{{ elixir('js/user/bjy-phone-public.js') }}"></script>
@endsection