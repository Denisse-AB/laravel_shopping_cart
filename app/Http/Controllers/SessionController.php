<?php

namespace App\Http\Controllers;

use App\User;
use App\SaveForLater;
use App\Items;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function store(Request $request, $item_id)
    {
        $item = Items::findOrFail($item_id);

        //int conversion
        $id = intval($item_id);

        //variables
        $cart = session()->get('cart');
        $size = $request->input('size');
        $qty =  $request->input('qty');
        $price =  $request->input('price');

        if (!$size) {

            return redirect()->back()->with('status', 'Please, Select a size.');
        }

        $checkdb = SaveForLater::where('item_id', $item_id)->exists();

        // if cart is empty create the cart.
        if(!$cart) {

            $cart = [
                     $id => [
                        "itemId" => $id,
                        "quantity" => $qty,
                        "size" => $size,
                        "price" => $price,
                        "subtotal" => $price * $qty,
                        "checkdb" => $checkdb,
                    ]
            ];

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Product added to cart successfully!');

        }

        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {

            return redirect()->back()->with('status', 'Product already added to the cart');

        }

        // if item not exist in cart then add to cart.
        $cart[$id] = [
                    "itemId" => $id,
                    "quantity" => $qty,
                    "size" => $size,
                    "price" => $price,
                    "subtotal" => $price * $qty,
                    "checkdb" => $checkdb,
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function show(Request $request)
    {
        $cart = session()->get('cart');
        
        if (!$cart) {

            $items = Items::all()->shuffle();

            return view('index', compact('items'));
        }

        $user = Auth::user();

        //filter table items
        $item_id = array_column(session('cart'), "itemId");
        $items = Items::find($item_id);

        //subtotal calculation
        $item_subtotal = array_column(session('cart'), "subtotal");
        $subtotal = array_sum($item_subtotal);

        return view('cart', compact('items', 'subtotal'));
    }

    public function delete(Request $request, $id)
    {
        $cart = session()->get('cart');

        $request->session('cart')->forget('cart.'.$id);

        return redirect()->back()->with('success', 'Item Deleted!');
    }

}