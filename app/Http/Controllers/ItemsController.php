<?php

namespace App\Http\Controllers;

use App\Items;
use App\Comments;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    public function index()
    {
        $items = Items::all()->shuffle();
        
        return view('index', compact('items'));
    }

    public function show($item)
    {
        $items = Items::where('id', $item)->first();

        $comments = Comments::where('item_id', $item)
            ->select('name', 'comment', 'created_at')
                ->latest()->get();

        return view('show', compact('items', 'comments'));
    }

}
