<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use SEOMeta;
use App\Models\News;

class NewsController extends Controller
{
    use SEOToolsTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $news = News::where('status', 1)->orderBy('created_at', 'desc')->paginate(12);
        $this->seo()->setTitle("News");

        return view('news.index', compact('news'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Request $request)
    {
        $post = News::where('slug', $slug)->firstOrFail();
        $news = News::where('status', 1)->where('id', '<>', $post->id)
            ->orderBy('created_at', 'desc')->limit(4)->get();

        $this->seo()->setTitle($post->seo_title);
        $this->seo()->setDescription($post->meta_description);

        return view('news.detail', compact('post', 'news'));
    }
}
