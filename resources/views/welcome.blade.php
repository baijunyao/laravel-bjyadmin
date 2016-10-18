<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <link rel="stylesheet" href="{{ elixir('css/public/base.css') }}">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                </div>
            @endif

            <div class="content">
                <button v-on:click="login">login</button>
                <button v-on:click="refresh">refresh</button>
            </div>
            <div>
                <form action="{{ url('test') }}" method="post">
                    {{ csrf_field() }}
                    <input type="text" name="name">
                    <input type="submit" value="提交">
                </form>
            </div>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="{{ asset('statics/vue/vue.js') }}"></script>
        <script src="{{ asset('statics/vue/vue-resource.min.js') }}"></script>
        <script src="{{ elixir('js/public/base.js') }}"></script>
        <script>
            var vm = new Vue({
                el: 'body',
                methods: {
                    login: function(){
                        var postData = {
                            email: 'junyao.bai@niuschools.com',
                            password: '123456'
                        };
                        this.$http.post("{{ url('api/authenticate') }}", postData).then(function (response) {
                            localStorage.setItem('Authorization', response.data.token);
                            console.log(localStorage.getItem('Authorization'));
                        })
                    },
                    refresh: function () {
                        this.$http.post("{{ url('api/test') }}").then(function (response) {
//                            console.log(localStorage.getItem('Authorization'));
                        })
                    }
                },
                ready: function () {
                    this.$http.post("{{ url('test') }}").then(function (response) {
                        console.log(response);
                    })
                }
            })
        </script>
    </body>
</html>
