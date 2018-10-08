<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
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
        /*$rules = [];
        $photos = count($this->$request('files'));
        foreach(range(0, $photos) as $index) {
            $rules['files.' . $index] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }*/

        $data = [];

        /*$request->validate([
            "files" => "required|array",
            "files.*" => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($request->hasfile('files'))
        {
            foreach($request->file('files') as $image)
            {
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $name);
                //$image->move(public_path().'/images/', $name);
                $data[] = $destinationPath."/".$name;
            }

            return response()->json([
                'data' => $data,
                'message' => "Images successfully uploaded."
            ], 200);
        }*/

        $request->validate([
            "file" => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8048'
        ]);

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $name = Auth::id()."-".time()."-".$image->getClientOriginalName();//.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/');
            $image->move($destinationPath, $name);

            return response()->json([
                'data' => $name,
                'image' => $destinationPath.$name,
                'message' => "Image successfully uploaded."
            ], 200);
        }

        return response()->json([
            'text' => "Something wrong!"
        ], 422);
    }

    /**
     * Delete resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $request->validate([
            "image" => 'required|string'
        ]);

        $image = $request->get('image');
        $pos = stripos($image, Auth::id()."-");

        if ($pos!== false && $pos==0)
        {
            unlink(public_path('/images/').$image);

            return response()->json([
                'message' => "Image successfully deleted."
            ], 200);
        }else{
            return response()->json([
                'text' => "You cannot delete this image, you are not the owner."
            ], 422);
        }
    }
}