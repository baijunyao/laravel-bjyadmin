@extends('public.bootstrap')

@section('title', '测试')

@section('body')

    <form action="{{ url('home/test/send_email') }}" method="post">
        {{ csrf_field() }}
        邮箱：<input type="text" name="email">
        内容：<input type="text" name="content">
        <input type="submit" value="发送邮件">
    </form>



@endsection