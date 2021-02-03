<?php

namespace App\Http\Controllers;

use App\Items;
use App\SaveForLater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SaveForLaterController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Items $item)
    {
        $user = Auth::user()->id;
        $id = $item->id;

        $db = auth()->user()->saveForLater()->create([
                'user_id' => $user,
                'item_id' => $id
            ]);

        $cart = $request->session('cart')->put('cart.'.$id.'.checkdb', true);

        return response()->json(200);
    }

    public function show(Request $request, $lang)
    {
       $user = Auth::user()->id;

       App::setlocale($lang);

       $wishlists = SaveForLater::where('user_id', $user)->select('item_id')->get();

       //empty collection.
       if ($wishlists->count() == 0) {
           $noItems = false;
        } else {
            $noItems = true;
        }

        //items filter.
       $items = Items::find($wishlists);

       return view('wishlist', compact('wishlists', 'noItems', 'items'));
    }

    public function delete(Request $request, $item_id)
    {
        $user = Auth::user()->id;

        auth()->user()->saveForLater->where('item_id', $item_id)->delete();

        $request->session('cart')->forget('cart.'.$item_id.'.checkdb');

        $saveForLater = SaveForLater::where('user_id', $user)->get();

       if ($saveForLater->count() == 0) {
            return redirect()->back()->with('status', 'Success, Your wishlist is empty!');

        } else {
            return redirect()->back()->with('status', 'Success, Item deleted!');

        }
    }
}
