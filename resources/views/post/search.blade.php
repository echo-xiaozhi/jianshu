@extends('layout.main')
@section('content')
    <div class="alert alert-success" role="alert">
        下面是搜索"{{$keyword}}"出现的文章，共{{$count}}条
    </div>
    <div class="col-sm-8 blog-main">
        @foreach ($data as $vo)
        <div class="blog-post">
            <h2 class="blog-post-title"><a href="/posts/{{$vo->id}}">{{$vo->title}}</a></h2>
            <p class="blog-post-meta">{{ $vo->created_at }} by <a href="#">{{$vo->name}}</a></p>

            <p>
                {!! str_limit($vo->content, 100, '···') !!}
            </p>
        </div>
        @endforeach
        {{$data->links()}}
    </div><!-- /.blog-main -->
@endsection