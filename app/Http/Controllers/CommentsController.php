<?php

namespace App\Http\Controllers;

use App\User;
use App\Items;
use App\Replies;
use App\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');   
    }

    public function show($item)
    {
        $comments = Comments::where('item_id', $item)->latest()->get();
        
        $replies = Replies::all();

        return response()->json([
            'comments' => $comments,
            'replies' => $replies
        ]);
    }

    /**
     * Store a new comment post.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $item)
    {
        $request->validate([
            'comment' => ['required', 'not_regex:([<>+/])', 'max:300'], //not_regex:/^.+$/i' <> 
        ]);

        $user = Auth::user()->id;
        $name = Auth::user()->name;

        $comment = $request->comment;
   
        $post = auth()->user()->comments()->create([
            'item_id' => $item,
            'user_id' => $user,
            'name' => $name,
            'comment' => $comment,
        ]);
            
        return response()->json($post);
    }

    public function delete($comment_id)
    {
        // Eloquent Query
        auth()->user()->comments()->where('id', $comment_id)->delete();

        return response()->json(200);
    }

    public function update(Request $request, $comment_id)
    {
        $request->validate([
            'text' => ['required', 'not_regex:([<>+/])', 'max:300'], //not_regex:/^.+$/i' <> 
        ]);

        $comment = Comments::find($comment_id);

        $text = $request->text;

        $comment->comment = $text; 

        $comment->save();

        return response()->json(200);
    }
}
