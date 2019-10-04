@extends('layouts.main')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8">

        @if (! $posts->count())
            <div class="alert alert-warning">
                <p>Nothing Found.</p>
            </div>

        @else
            
            @isset ($categoryName)
                <div class="alert alert-info">
                    <p>Category: <strong> {{$categoryName}} </strong></p>
                </div>
            @endisset

            @isset ($authorName)
                <div class="alert alert-info">
                    <p>Author Name: <strong> {{$authorName}} </strong></p>
                </div>
            @endisset

            @foreach ($posts as $post)            
                <article class="post-item">

                @if($post->image_url)
                    <div class="post-item-image">
                        <a href="{{route('blog.show',$post->slug)}}">
                            <img src="{{$post->image_url}}" alt="">
                        </a>
                    </div>
                @endif


                    <div class="post-item-body">
                        <div class="padding-10">
                            <h2><a href="{{route('blog.show',$post->slug)}}">{{$post->title}}</a></h2>
                            <p>{!! $post->excerpt_html !!}</p>
                        </div>

                        <div class="post-meta padding-10 clearfix">
                            <div class="pull-left">
                                <ul class="post-meta-group">
                                    <li><i class="fa fa-user"></i><a href="{{ route('author.post',$post->author->slug) }}">{{ $post->author->name}}</a></li>
                                    <li><i class="fa fa-clock-o"></i><time> {{$post->date}}</time></li>
                                    <li><i class="fa fa-tags"></i><a href="{{ route('category', $post->category->slug) }}">{{ $post->category->title }}</a></li>
                                    <li><i class="fa fa-comments"></i><a href="#">4 Comments</a></li>
                                </ul>
                            </div>
                            <div class="pull-right">
                                <a href="{{route('blog.show',$post->slug)}}">Continue Reading &raquo;</a>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach

        @endif

            

                <nav>
                  {{-- <ul class="pager">
                    <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> Newer</a></li>
                    <li class="next"><a href="#">Older <span aria-hidden="true">&rarr;</span></a></li>
                  </ul> --}}

                  {{$posts->links()}}
                </nav>
            </div>


        @include('layouts.sidebar')
        </div>
    </div>
@endsection