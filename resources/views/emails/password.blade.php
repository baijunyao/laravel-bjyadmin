@extends('public.bootstrap')


@section('title', '前往重置密码')


@section('body')

    点击这里重置密码: {{ url('password/reset/'.$token) }}

@endsection