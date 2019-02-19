<?php

namespace App\Http\Controllers;

use App\Mail\EmailFromChat;
use App\Mail\EmailFromChatToCoachNotRegistered;
use App\Models\User;
use App\Models\Group;
use App\Models\GroupMessage;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Mail;

class ThreadController extends Controller
{
    /**
     * Instantiate a new controller instance.
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
        $user = Auth::user();
        $threads = Thread::forUser($user->id)->latest('updated_at')->distinct()->get();

        foreach($threads as &$thread)
        {
            $thread->participantsString = $thread->participantsString();
            $thread->userUnreadMessagesCount = $thread->userUnreadMessagesCount($user->id);
        }

        return view('im.index', compact(['user', 'threads']));
    }

    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function store(Request $request)
    {

    }

    public function participants($channel_id, Request $request)
    {
        $thread = Thread::findOrFail($channel_id);
        $users = User::whereIn('id', $thread->participantsUserIds())->get();
        return response()->json($users,  200);
    }

    public function messages($channel_id, Request $request)
    {
        $user = $request->user();
        $thread = Thread::findOrFail($channel_id);
        $thread->markAsRead($user->id);

        return response()->json($thread->messages()->with(['user'])->get(),  200);
    }

    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function messageStore($channel_id, Request $request)
    {
        $input = $request->all();
        $user = $request->user();

        //Save GroupMessage
        if(isset($input['group_id']) && $input['group_id']>0)
        {
            $group = Group::findOrFail( $input['group_id']);

            if(strpos($group->owner->email, '@campusteam.tv')!==false)
            {
                GroupMessage::create([
                    'from' => $user->id,
                    'group_id' => $input['group_id'],
                    'body' => $input['message'],
                ]);

                $gmc = GroupMessage::where('from', $user->id)->where('group_id', $input['group_id'])->count();

                //To unregistered coach
                if($gmc==1 && !empty($group->coach_email))
                {
                    $unreadCount = GroupMessage::where('group_id', $input['group_id'])->groupBy('from')->count();

                    try{
                        $data = [];

                        $data['from'] = $user;
                        $data['count'] = $unreadCount;
                        $data['message'] = Str::limit($input['message'], 45, ' ...');
                        $data['to'] = [
                            'name' => $group->coach_name,
                            'last_name' => $group->coach_last_name,
                            'email' => $group->coach_email
                        ];

                        Mail::to($group->coach_email)->send(new EmailFromChatToCoachNotRegistered($data));

                    } catch (\Exception $ex) {
                        //to log echo $ex->getMessage();
                    }
                }

                return response()->json([], 200);
            }
        }

        if($channel_id>0)
        {
            $thread = Thread::findOrFail($channel_id);
            $participants = [];
        }else{
            $participants = $request->get('participants');
            $users = User::whereIn('id', $participants)->get();

            $u = [$user->id, $participants[0]];
            $th = Thread::between($u);

            if($th->count()>0)
            {
                $thread = $th->first();
                $participants = [];
            }else{
                $subject = $users[0]->name;

                $thread = Thread::create([
                    'subject' => $subject,
                ]);

                // Recipients
                $thread->addParticipant($participants);

                // Sender
                Participant::create([
                    'thread_id' => $thread->id,
                    'user_id' => $user->id,
                    'last_read' => new Carbon,
                ]);
            }
        }

        // Message
        $message = Message::create([
            'thread_id' => $thread->id,
            'user_id' => $user->id,
            'body' => $input['message'],
        ]);

        //Mark all messages of chat read
        $thread->markAsRead($user->id);

        $message = Message::where("id", $message->id)
            ->with(['user'])->first()->toArray();

        $thread->load(['participants.user']);
        $thread->participantsString = $thread->participantsString();
        $thread->userUnreadMessagesCount = $thread->userUnreadMessagesCount($user->id);
        $thread->latestMessage = $thread->getLatestMessageAttribute();

        /*$unreads = [];
        $threads = Thread::forUser($user->id)->get();
        foreach($threads as $channel)
        {
            $unreads[$channel->id] = $channel->userUnreadMessagesCount($user->id);
        }*/

        // Dispatch an event. Will be broadcasted over Redis.
        event(new MessageSent($thread->id, $message));

        //Send to participant email notify
        $threadUserIds = $thread->participantsUserIds();
        if($thread->messages()->count()==1)
        {
            if(($key = array_search($user->id, $threadUserIds)) !== FALSE)
            {
                unset($threadUserIds[$key]);

                foreach($threadUserIds as $toid)
                {
                    $to = User::where('id', $toid)->first();
                    $data = [];
                    $data['from'] = $user;
                    $data['message'] = Str::limit($input['message'], 45, ' ...');
                    $data['count'] = $thread->userUnreadMessagesCount($to->id);
                    $data['to'] = $to;

                    try{
                        Mail::to($to->email)->send(new EmailFromChat($data));
                    } catch (\Exception $ex) {
                        //to log echo $ex->getMessage();
                    }
                }
            }
        }

        return response()->json([
            'message' => $message,
            'thread' => $thread,
            'participants' => $participants
        ], 200);
    }
}
