<?php

namespace App\Http\Controllers;

use App\User;
use App\Items;
use App\SaveForLater;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function store(Request $request, $item_id)
    {
        $item = Items::findOrFail($item_id);

        $checkdb = false;

        if (Auth::check()) {
            $user_id = Auth::user()->id;

            $checkdb = SaveForLater::where([
                ['item_id', $item_id],
                ['user_id', $user_id]
            ])->exists();
        }

        //int conversion
        $id = intval($item_id);

        //variables
        $cart = session()->get('cart');
        $qty =  $request->input('qty');
        $price =  $request->input('price');

        // If the cart is empty, create the cart.
        if(!$cart) {

            $cart = [
                     $id => [
                        "itemId" => $id,
                        "quantity" => $qty,
                        "price" => $price,
                        "subtotal" => $price * $qty,
                        "checkdb" => $checkdb,
                    ]
            ];

            session()->put('cart', $cart);

            if (session('locale') === 'es') {
                return redirect()->back()->with('success', 'Poducto añadido al carrito!');
            }

            return redirect()->back()->with('success', 'Product added to cart successfully!');

        }

        // If the cart is not empty, then check if this product exist.
        if(isset($cart[$id])) {

            if (session('locale') === 'es') {
                return redirect()->back()->with('status', 'Tu producto ya está en el carrito!');
            }

            return redirect()->back()->with('status', 'Product already added to the cart');
        }

        // If the product doesn't exist in cart then add it to cart.
        $cart[$id] = [
                    "itemId" => $id,
                    "quantity" => $qty,
                    "price" => $price,
                    "subtotal" => $price * $qty,
                    "checkdb" => $checkdb,
        ];

        session()->put('cart', $cart);

        if (session('locale') === 'es') {
            return redirect()->back()->with('success', 'Poducto añadido al carrito!');
        }

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

        if (!$cart) {

            $items = Items::all()->shuffle();

            return view('index', compact('items'));
        }

        return redirect()->back();

    }

}