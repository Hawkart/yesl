<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use App\Models\Game;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Requests\UserPasswordUpdateRequest;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Facades\Storage;
use Image;
use Cmgmyr\Messenger\Models\Thread;
use Hootlex\Friendships\Models\Friendship;

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
        $this->seo()->setTitle('Resume');
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

        $groups = $user->groups()->paginate(10);
        $friends = $user->getFriends(10);

        if(Auth::user()->id!=$user->id)
        {
            $mutual = $user->getMutualFriends(Auth::user());
        }else{
            $mutual = [];
        }

        $this->seo()->setTitle($user->name);

        return view ('users.detail', compact(['user', 'groups', 'friends', 'mutual']));
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
    public function update(UserRequest $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $data['name'] = trim($data['first_name']." ".$data['last_name']);
        $user->update($data);

        if ($request->expectsJson() && $request->ajax())
            return response()->json([
                'message' => 'Resume has been updated!',
                'data' => $data
            ]);
        else
            abort(404);
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
            $defaults = ['default/avatar_team.jpg', 'default/avatar_user.jpg'];
            if(file_exists($path) && !in_array($user->avatar, $defaults) && strpos($user->avatar, 'users/default')===false)
                unlink($path);
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
            'message' => "Avatar has been successfully updated."
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
            'message' => "Overlay has been successfully updated."
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
                'message' => "Your password has been successfully updated."
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
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function applications(Request $request)
    {
        $user = Auth::user();
        $applications = [];

        if(!$user->isCoach())
        {
            $applications = $user->applications()
                ->search($request->all())
                ->with(['user', 'team', 'profile', 'team.university', 'team.game'])
                ->get();

            return view('lk.applications', compact(['user', 'applications']));
        }else{
            if($user->university)
                $teams = $user->university->teams()->pluck('id')->toArray();
            else
                $teams = [];

            if($teams)
                $applications = Application::whereIn('team_id', $teams)->search($request->all())
                    ->with(['user', 'team', 'profile', 'team.university', 'team.game'])
                    ->paginate(12);

            $games = [0 => 'Select game'] + Game::all()->pluck('title', 'id')->toArray();

            return view('applications.index', compact(['user', 'applications', 'games']));
        }
    }

    /**
     * Profiles of user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function apiProfiles()
    {
        $user = Auth::user();
        $profiles = $user->profiles()->with(['game'])->get();

        return response()->json($profiles, 200);
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

        $groups = $user->groups()
            ->where(function($q) use ($user) {
                $q->active()
                    ->orWhere('owner_id', $user->id);
            })->search($request)->orderBy('id', 'desc')->paginate(12);

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
        $groups = $user->groups()->paginate(12);

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

        $friends = $user->getFriends()->pluck('id')->toArray();

        //Add admin id to
        $admins = User::admins()->where('id', '<>', Auth::user()->id)->pluck('id')->toArray();

        if(count($admins))
        {
            $friends = $friends + $admins;
            $friends = array_unique($friends);
        }

        $posts = Post::where('user_id', '<>', $user->id)
            ->whereIn('group_id', $groups)
            ->orWhere(function ($query) use ($friends) {
                $query->whereIn('user_id',  $friends)
                    ->where('group_id', 0);
            })->with(['user', 'likes', 'comments', 'likes.user', 'comments.user', 'comments.likes', 'media', 'group',
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
            ->with(['user', 'likes', 'comments', 'likes.user', 'comments.user', 'comments.likes', 'media', 'group',
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
                'message' => "You don't have access to view these chats."
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

    /**
     * Add friend request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function befriend(Request $request)
    {
        $user = Auth::user();
        $friend = User::findOrFail($request->get('id'));

        $result = [];
        if(!$user->hasFriendRequestFrom($friend) && !$user->hasSentFriendRequestTo($friend) && !$user->getFriendship($friend))
        {
            $result = $user->befriend($friend);
        }

        return response()->json($result, 200);
    }

    /**
     * Accept friend request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function acceptFriendRequest(Request $request)
    {
        $user = Auth::user();
        $friend = User::findOrFail($request->get('id'));

        $result = [];
        //if($user->hasFriendRequestFrom($friend))
        if(Friendship::betweenModels($user, $friend)->whereSender($friend)->exists())
        {
            $result = $user->acceptFriendRequest($friend);
        }

        return response()->json($result, 200);
    }

    /**
     * Accept friend request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function denyFriendRequest(Request $request)
    {
        $user = Auth::user();
        $friend = User::findOrFail($request->get('id'));

        $result = [];
        if($user->hasFriendRequestFrom($friend))
        {
            $result = $user->denyFriendRequest($friend);
        }

        return response()->json($result, 200);
    }

    /**
     * Remove from friend list
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unfriend(Request $request)
    {
        $user = Auth::user();
        $friend = User::findOrFail($request->get('id'));

        $result = [];
        if($user->isFriendWith($friend))
        {
            $result = $user->unfriend($friend);
        }

        return response()->json($result, 200);
    }

    /**
     * Friends of current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function friends(Request $request)
    {
        $friends = Auth::user()->getFriends(12);
        return response()->json($friends, 200);
    }

    /**
     * Possible friends of current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * TODO: Add university peoples if possible empty
     */
    public function possibleFriends(Request $request)
    {
        $user = Auth::user();

        //exclude friends, current user and pendings
        $friends = $user->getFriends()->pluck('id')->toArray();
        //$friendships = $user->getPendingFriendships();
        //$friends = array_merge($friends, $friendships->pluck('sender_id')->toArray());
        //$friends = array_merge($friends, $friendships->pluck('recipient_id')->toArray());

        $recipients = $user->getPendingOutgoingFriends()->pluck('recipient_id')->toArray();
        $senders = $user->getPendingIncomingFriends()->pluck('sender_id')->toArray();

        $friends = array_merge($friends, $recipients);
        $friends = array_merge($friends, $senders);

        $friends[] = $user->id;
        $friends = array_unique($friends);

        $possibles = [];
        if(!$request->has('q'))
            $possibles = $user->getFriendsOfFriends(12);

        if(!isset($possibles['total']) || $possibles['total']==0)
        {
            $possibles = User::orderBy('name', 'asc')
                ->whereNotIn('id', $friends)
                ->search($request)
                ->verified()
                ->paginate(12);
        }

        $possibles->getCollection()->transform(function ($friend) use ($user) {
            $friend['mutualCount'] = $user->getMutualFriendsCount($friend);
            return $friend;
        });

        return response()->json($possibles, 200);
    }

    /**
     * Pending incoming friend requests
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function friendRequestsIn(Request $request)
    {
        $user = Auth::user();
        $requests = $user->getPendingIncomingFriends()->where('status', '<>', \Hootlex\Friendships\Status::ACCEPTED)->with(['sender'])->paginate(12);

        $requests->getCollection()->transform(function ($friendship) use ($user) {
            $friendship['sender']['mutualCount'] = $user->getMutualFriendsCount($friendship['sender']);
            return $friendship;
        });

        return response()->json($requests, 200);
    }

    /**
     * Pending Outgoing friend requests
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function friendRequestsOut(Request $request)
    {
        $user = Auth::user();
        $requests = $user->getPendingOutgoingFriends(\Hootlex\Friendships\Status::PENDING)->with(['recipient'])->paginate(12);

        $requests->getCollection()->transform(function ($friendship) use ($user) {
            $friendship['recipient']['mutualCount'] = $user->getMutualFriendsCount($friendship['recipient']);
            return $friendship;
        });

        return response()->json($requests, 200);
    }
}
