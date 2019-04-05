@extends('layouts.app')

@section('content')
    <section class="blog-post-wrap">
        <div class="row">
            <div class="col col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                <div class="ui-block">
                    <article class="hentry blog-post">
                        <div class="post-thumb">
                            <a href="{!! route('news-post', ['slug' => $post->slug]) !!}">
                                <img src="{{ Storage::disk('public')->url($post->image)}}" alt="cover image">
                            </a>
                        </div>
                        <div class="post-content">
                            <a href="{!! route('news-post', ['slug' => $post->slug]) !!}" class="h1 post-title">
                                {{$post->title}}
                            </a>

                            <a href="{!! route('news-post', ['slug' => $post->slug]) !!}" class="h4 post-title">
                                {{$post->subtitle}}
                            </a>

                            <div>
                                {!!$post->body!!}
                            </div>

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

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 text-center">
                        <a href="/news" class="btn btn-md btn-blue c-white mb-5 mt-2">
                            More News
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="crumina-module crumina-heading with-title-decoration">
                        <h5 class="heading-title">Related News</h5>
                    </div>
                </div>
                <div class="row">
                    @if($news->count())
                        @foreach($news as $post)
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="ui-block">
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
                                            <a href="{!! route('news-post', ['slug' => $post->slug]) !!}" class="h5 post-title">
                                                {{$post->subtitle}}
                                            </a>
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
            </div>
        </div>
    </section>
@endsection
