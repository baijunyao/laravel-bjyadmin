@extends('public.bootstrap')

@section('title', '测试')

@section('body')

    <form action="{{ url('home/test/send_email') }}" method="post">
        {{ csrf_field() }}
        邮箱：<input type="text" name="email">
        内容：<input type="text" name="content">
        <input type="submit" value="发送邮件">
    </form>

    <form action="{{ url('home/test/upload') }}" method="post"  enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="file">
        <input type="text" name="test" id="">
        <input type="submit" value="上传">
    </form>

@endsection