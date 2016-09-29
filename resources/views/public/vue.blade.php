<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>@yield('title') - bjyadmin</title>
    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{asset('/css/public/base.css')}}" />
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
<script src="{{asset('/statics/vue/vue.js')}}"></script>
<script src="{{asset('/statics/vue/vue-resource.min.js')}}"></script>
<script src="{{asset('/js/public/base.js')}}"></script>
@yield('js')
</body>
</html>
