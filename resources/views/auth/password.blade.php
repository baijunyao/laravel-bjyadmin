@extends('public.bootstrap')

@section('title', '忘记密码')

@section('body')

    <form method="POST" action="/password/email">
        {!! csrf_field() !!}

        <div>
            Email
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            <button type="submit">
                发送密码重置链接
            </button>
        </div>
    </form>

@endsection