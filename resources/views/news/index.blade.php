@extends('layouts.app')

@section('content')
    <section class="blog-post-wrap">
        <h2 class="landing-content">News</h2>
        <div class="row">
            @if($news->count())
                @foreach($news as $post)
                    <div class="col col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="ui-block" data-mh="choose-item">
                            <article class="hentry blog-post">

                                <div class="post-thumb">
                                    <a href="{!! route('news-post', ['slug' => $post->slug]) !!}">
                                        <img src="{{ Storage::disk('public')->url($post->image)}}" alt="cover image">
                                    </a>
                                </div>

                                <div class="post-content">
                                    <a href="{!! route('news-post', ['slug' => $post->slug]) !!}" class="h4 post-title">
                                       {{$post->title}}
                                    </a>
                                    <p>{{$post->excerpt}}</p>

                                    <div class="author-date">
                                        <a class="h6 post__author-name fn" href="#">{{$post->city}}, {{$post->country}}</a>
                                        <div class="post__date">
                                            <time class="published">
                                                {{$post->created_at->diffForHumans()}}
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <nav aria-label="Page navigation">
                    {{ $news->appends(request()->input())->links() }}
                </nav>
            </div>
        </div>
    </section>
@endsection
