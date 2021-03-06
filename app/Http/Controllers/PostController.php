<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Storage;
use Image;
use File;
use Cache;

class PostController extends Controller
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
        $user = Auth::user();

        $group_id = 0;
        if($request->has('group_id'))
        {
            $groups = $user->groups()->pluck('group_id')->toArray();
            $group_id = intval($request->get('group_id'));

            if($group_id>0 && !in_array($group_id, $groups))
            {
                return response()->json([
                    'error' => 'Only group members have access to this page.'
                ], 422);
            }
        }

        if(empty($request->get('text')) && !$request->has('links') && !$request->has('images'))
        {
            return response()->json([
                'text' => "Post can't be empty."
            ], 422);
        }

        $parent_id = 0;
        if($request->has('parent_id'))
        {
            $parent_id = $request->get('parent_id');
        }

        $additional = [];
        if($request->has('links'))
        {
            $additional['links'] = $request->get('links');
        }

        $postBody = $this->parseUsernames($request->get('text'));

        $post = Post::create([
            'user_id' => $user->id,
            'group_id' => $group_id,
            'text' => $postBody,
            'additional' => $additional,
            'parent_id' => $parent_id
        ]);

        if($post)
        {
            if($request->has('images')) {
                $images = $request->get('images');
                if (!empty($images)) {
                    foreach ($images as $image) {
                        $post
                            ->addMedia(public_path('/images/') . $image)
                            ->toMediaCollection('images');
                    }
                }
            }

            $post->load(['user', 'likes', 'comments', 'likes.user', 'comments.reply', 'comments.reply.user', 'comments.user', 'media', 'group',
                'parent', 'parent.user', 'parent.group', 'parent.media']);

            return response()->json([
                'data' => $post,
                'message' => "Post has been successfully created."
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
                if (!User::where('nickname', $username)->get()->isEmpty())
                {
                    $postBody = preg_replace("/(@\\w+)/", '<a href="/users/' . $username . '">${1}</a>', $postBody);
                    // Notify
                    //$recipient = User::whereUsername($username)->first();
                    //$sender = Auth::user();
                    //Mail::to($recipient)->send(new PostReply($recipient, $sender));
                }
            }
        }

        /*preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $postBody, $urls);
        if (!empty($urls))
        {
            foreach ($urls[0] as $url)
            {
                $postBody = str_replace($url, '<a href="' . $url . '" target="_blank">'.$url.'</a>', $postBody);
            }
        }*/

        $postBody = preg_replace("#(https?|ftp)://\S+[^\s.,>)\];'\"!?]#",'<a href="\\0" target="_blank">\\0</a>',$postBody);

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
