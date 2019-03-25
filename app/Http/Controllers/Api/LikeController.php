<?php
namespace App\Http\Controllers\Api;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $model_name = 'App\\Models\\'.$request->get('likeable_type');
        $id = intval($request->get('likeable_id'));
        
        $like = Like::withTrashed()->where('likeable_type', $model_name)
            ->where('likeable_id', $id)
            ->where('user_id', $user->id)
            ->first();

        $model = $model_name::where('id', $id)->first();

        if($like)
        {
            if ($like->trashed()) {
                $like->restore();
                $m = "Like restored";
            }else{
                $like->delete();
                $m = "Like deleted";
            }

            return response()->json([
                'count' => $model->likes()->count(),
                'data' => $like,
                'message' => $m
            ], 200);
        }else{

            $like = Like::create([
                'user_id' => $user->id,
                'likeable_id' => $model->id,
                'likeable_type' => $model_name
            ]);

            return response()->json([
                'count' => $model->likes()->count(),
                'data' => $like,
                'message' => "Like successfully created."
            ], 200);
        }

        return response()->json([
            'error' => "Something wrong"
        ], 422);
    }
}
