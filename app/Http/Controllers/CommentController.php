<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Post;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Storage;
use Image;
use File;
use Cache;

class CommentController extends Controller
{
    use SEOToolsTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'post_id' => 'required|integer',
        ]);

        $post_id = $request->get('post_id');
        $post = Post::findOrFail($post_id);
        $postBody = $this->parseUsernames($request->get('comment'));

        $additional = [];
        if($request->has('links'))
        {
            $additional['links'] = $request->get('links');
        }

        $comment = $post->comments()->create([
            'user_id' => Auth::user()->id,
            'post_id' => $post_id,
            'reply_id' => intval($request->get('reply_id')),
            'comment' => $postBody,
            'additional' => $additional
        ]);

        if($comment)
        {
            $comment->load(['user', 'likes', 'likes.user']);

            return response()->json([
                'data' => $comment,
                'message' => "Comment successfully created."
            ], 200);
        }
    }

    /**
     * Parse usernames from post body.
     *
     * @param  string $postBody
     * @return string
     */
    private function parseUsernames($postBody)
    {
        preg_match_all("/@(\\w+)/", $postBody, $usernames);

        if (!empty($usernames))
        {
            foreach ($usernames[1] as $username)
            {
                if (!User::whereUsername($username)->get()->isEmpty())
                {
                    $postBody = preg_replace("/(@\\w+)/", '<a href="/users/' . $username . '">${1}</a>', $postBody);
                    // Notify
                    //$recipient = User::whereUsername($username)->first();
                    //$sender = Auth::user();
                    //Mail::to($recipient)->send(new PostReply($recipient, $sender));
                }
            }
        }

        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $postBody, $urls);
        if (!empty($urls))
        {
            foreach ($urls[0] as $url)
            {
                $postBody = str_replace($url, '<a href="' . $url . '" target="_blank">'.$url.'</a>', $postBody);
            }
        }

        return $postBody;
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}