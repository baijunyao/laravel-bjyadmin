<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>@yield('title') - bjyadmin</title>
    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/statics/bootstrap-3.3.5/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/statics/font-awesome-4.4.0/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ elixir('css/public/base.css') }}" />
    @yield('css')
</head>
<body>

@if(Session::has('alert-message'))
    <div class="alert {{session('alert-class')}}">
        <ul>
            <li>{{ session('alert-message') }}</li>
        </ul>
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@yield('body')


<!-- 引入bootstrjs部分开始 -->
<script src="{{ asset('/statics/js/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('/statics/bootstrap-3.3.5/js/bootstrap.min.js') }}"></script>
<script src="{{ elixir('js/public/base.js') }}"></script>
@yield('js')
</body>
</html>
