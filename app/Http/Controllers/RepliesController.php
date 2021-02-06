<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $commentId)
    {
        $request->validate([
            'reply' => ['required', 'not_regex:([<>+/])', 'max:300'], //not_regex:/^.+$/i' <>
        ]);

        $user = Auth::user()->id;
        $name = Auth::user()->name;

        $reply = $request->reply;

        $post = auth()->user()->replies()->create([
            'comments_id' => $commentId,
            'user_id' => $user,
            'name' => $name,
            'reply' => $reply,
        ]);

        return response()->json($post);
    }

    public function delete($reply_id)
    {
        auth()->user()->replies()->where('id', $reply_id)->delete();

        return response()->json(200);
    }
}
