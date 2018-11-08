<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\UserPasswordUpdateRequest;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Facades\Storage;
use Image;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;

class UserController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the personal form.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $this->seo()->setTitle('Personal settings');
        $user = Auth::user();
        return view('lk.personal', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Request $request)
    {
        $user = User::where('nickname', $slug)
            ->firstOrFail();

        $this->seo()->setTitle($user->name);

        return view ('users.detail', compact(['user']));
    }

    /**
     * Show the password form.
     *
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        $this->seo()->setTitle('Change password');

        $user = Auth::user();
        return view('lk.password', compact('user'));
    }


    /**
     * Update user personal data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required',
            'date_birth' => 'required|date_format:Y-m-d|before:today'
        ];

        $request->validate($validator);
        $user->update($request->all());

        return back()->with('status', "Personal info updated!");
    }

    /**
     * Update user's avatar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();
        $params = $request->all();

        if($user->avatar)
        {
            $path = public_path() . '/storage/' . $user->avatar;

            if(file_exists($path) && !in_array($user->avatar, ['default/avatar_team.jpg', 'default/avatar_user.jpg', 'users/default.png']))
            {
                unlink($path);
            }
        }

        $path = Storage::disk('public')->putFile(
            'avatars', $request->file('files')
        );

        /**
         * Crop & resize using client crop data
         */

        if($request->has('toCropImgH'))
        {
            $crop = [
                'h' => (int)$params["toCropImgH"],
                'w' => (int)$params["toCropImgW"],
                'x' => (int)$params["toCropImgX"],
                'y' => (int)$params["toCropImgY"]
            ];
        }else{
            $crop = [
                'h' => (int)$params["h"],
                'w' => (int)$params["w"],
                'x' => (int)$params["x"],
                'y' => (int)$params["y"]
            ];
        }

        $img = Image::make('storage/'.$path);
        $img->crop($crop['h'], $crop['w'], $crop['x'], $crop['y']);
        $img->resize(120, 120);
        $img->save('storage/'.$path);
        $img->destroy();

        $user->avatar = $path;
        $user->update();

        return response()->json([
            'data' => $user,
            'message' => "Avatar successfully updated."
        ]);
    }

    /**
     * Update overlay.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updateOverlay(Request $request)
    {
        $user = Auth::user();
        if($user->overlay)
        {
            $path = public_path() . '/storage/' . $user->overlay;
            if(file_exists($path) && !in_array($user->overlay, ['default/overlay_game.jpg', 'default/overlay_team.jpg', 'default/overlay_user.jpg']))
            {
                unlink($path);
            }
        }

        $path = Storage::disk('public')->putFile(
            'avatars', $request->file('files')
        );
        $user->overlay = $path;
        $user->update();

        return response()->json([
            'data' => $user,
            'message' => "Overlay successfully updated."
        ]);
    }

    /**
     * Update user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function updatePassword(UserPasswordUpdateRequest $request)
    {
        $user = Auth::user();

        if($result = $user->update([
            'password' => \Hash::make($request->get('password'))
        ]))
        {
            return response()->json([
                'data' => $user,
                'message' => "Password successfully updated."
            ]);
        }

        return response()->json([
            'error' => 'Something wrong'
        ], 422);
    }

    /**
     * Profiles of user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function profiles()
    {
        $user = Auth::user();
        $profiles = $user->profiles()->with(['game'])->get();

        return view('lk.profiles.index', compact(['user', 'profiles']));
    }

    /**
     * Groups of auth user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function myGroups(Request $request)
    {
        $user = Auth::user();
        $groups = $user->groups()->search($request)->orderBy('id', 'desc')->paginate(12);

        return view('groups.index', compact(['user', 'groups']));
    }

    /**
     * Groups of user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function groups($id, Request $request)
    {
        $user = User::findOrFail($id);
        $groups = $user->profiles()->paginate(12);

        return view('lk.groups.index', compact(['user', 'groups']));
    }


    /**
     * Feeds of current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function feeds($id, Request $request)
    {
        //$user = Auth::user();
        $user = User::findOrFail($id);
        $groups = $user->groups()->pluck('group_id')->toArray();

        $posts = Post::whereIn('group_id', $groups)
            ->where('user_id', '<>', $user->id)
            ->with(['user', 'likes', 'comments', 'likes.user', 'comments.user', 'comments.likes', 'media',
                'parent', 'parent.user', 'parent.group', 'parent.media'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()->json($posts);
    }

    /**
     * Wall of current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function wall($id, Request $request)
    {
        //$user = Auth::user();
        $user = User::findOrFail($id);

        $posts = Post::where('group_id', 0)
            ->where('user_id', $user->id)
            ->with(['user', 'likes', 'comments', 'likes.user', 'comments.user', 'comments.likes', 'media',
                'parent', 'parent.user', 'parent.group', 'parent.media'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()->json($posts);
    }

    /**
     * Wall of current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function threads($id, Request $request)
    {
        if(Auth::user()->id!=$id)
        {
            return response()->json([
                'message' => "You couldn't view chats of another user!"
            ], 422);
        }

        if($request->has('q'))
        {
            $q = $request->get('q');
            $threads = [];

            $threads['users'] = User::where("name", 'like', "%".$q."%")
                ->where('id', '<>', $id)->get();

            $threads['channels'] = Thread::forUser($id)
                ->where("subject", "like", "%".$q."%")
                ->with(['participants.user'])
                ->latest('updated_at')
                ->distinct()->get();

            foreach($threads['users'] as $key=>$participant)
            {
                //check if exists chat between two users
                if(Thread::between([$id, $participant->id])->count()>0)
                {
                    unset($threads['users'][$key]);
                }
            }

            foreach($threads['channels'] as &$thread)
            {
                $thread->participantsString = $thread->participantsString();
                $thread->userUnreadMessagesCount = $thread->userUnreadMessagesCount($id);
                $thread->latestMessage = $thread->getLatestMessageAttribute();
            }

        }else{
            $threads = Thread::forUser($id)
                ->with(['participants.user'])
                ->latest('updated_at')
                ->distinct()->get();

            foreach($threads as &$thread)
            {
                $thread->participantsString = $thread->participantsString();
                $thread->userUnreadMessagesCount = $thread->userUnreadMessagesCount($id);
                $thread->latestMessage = $thread->getLatestMessageAttribute();
            }
        }

        //$threads = Thread::forUserWithNewMessages($id)->latest('updated_at')->get();

        return response()->json($threads, 200);
    }
}
