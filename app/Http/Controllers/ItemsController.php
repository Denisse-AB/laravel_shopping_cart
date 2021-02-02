<?php

namespace App\Http\Controllers;

use App\Items;
use App\Comments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class ItemsController extends Controller
{
    public function index()
    {
        $items = Items::all()->shuffle();

        return view('index', compact('items'));
    }

    public function show($item, $lang)
    {
        $items = Items::where('id', $item)->first();

        App::setlocale($lang);

        $comments = Comments::where('item_id', $item)
            ->select('name', 'comment', 'created_at')
                ->latest()->get();

        return view('show', compact('items', 'comments'));
    }

}
