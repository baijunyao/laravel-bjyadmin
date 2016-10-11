@extends('public.bootstrap')

@section('title', '测试分页')


@section('body')

    <div class="container">
        <ul>
            @foreach ($posts as $post)
                <li>{{ $post->title }}</li>
            @endforeach
        </ul>
    </div>

    {!! $posts->render() !!}

@endsection