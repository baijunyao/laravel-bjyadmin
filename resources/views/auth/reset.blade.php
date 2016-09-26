@extends('public.bootstrap')

@section('title', '重置密码')


@section('body')

    <form method="POST" action="/password/reset">
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            Email：<input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            新密码：<input type="password" name="password">
        </div>

        <div>
            确认密码：<input type="password" name="password_confirmation">
        </div>

        <div>
            <button type="submit">
                重置密码
            </button>
        </div>
    </form>

@endsection