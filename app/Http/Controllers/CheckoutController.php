<?php

namespace App\Http\Controllers;

use App\User;
use App\Items;
use App\Orders;
use Stripe\Stripe;
use App\SaveForLater;
use GuzzleHttp\Client;
use App\Mail\ReceiptMail;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Stripe\Exception\CardException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        $cart = session()->get('cart');

        if (!$cart) {

            return redirect('/');
        }

        //query to find multiple items.
        $item_id = array_column(session('cart'), "itemId");
        $items = Items::find($item_id);

        $item_subtotal = array_column(session('cart'), "subtotal");
        $subtotal = (array_sum($item_subtotal));
        $tax_rate = 0.115;
        $tax = number_format($subtotal * $tax_rate, 2);
        $total = number_format($subtotal + $tax, 2);

        Stripe::setApiKey(getenv('STRIPE_SECRET'));

        $intent = PaymentIntent::create([
            'amount' => intval(strval($total * 100)),
            'receipt_email' => $user->email,
            'currency' => 'usd',
                'shipping' => [
                    'name' => $user->name,
                    'phone' => '787-000-0000',
                    'address' => [
                    'line1' => $user->address,
                    'city' => $user->city,
                    'state' => $user->state,
                    'postal_code' => $user->zip,
                    ],
                ],
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);
        //send to view the payment intent.
        return view('checkout', [
            'items' => $items,
            'user' => $user,
            'total' => $total,
            'tax' => $tax,
            'subtotal' => $subtotal,
            'intent' => $intent
        ]);
    }

    public function store(Request $request,Response $response, $user)
    {
        try {

        $customer = User::findOrFail($user);
        $cart = session()->get('cart');
        $addressLine1 = $request->input('address');
        $total = $request->input('total');
        $tax = $request->input('tx');
        $paymentId = $request->input('paymentID');

        //insert in orders table.
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://js.stripe.com/v3/');

        foreach ($cart as $key => $value) {
            $price = session('cart')[$key]['price'];
            $itemIds = session('cart')[$key]['itemId'];
            $qty = session('cart')[$key]['quantity'];

            $db = auth()->user()->orders()->create([
                'user_id' => $customer,
                'item_id' => $itemIds,
                'qty' => $qty,
                'total' => $total,
                'tax' => $tax,
                'status' => $response->getStatusCode(),
                'orderID' => $paymentId
            ]);
        }

        $request->session()->forget('cart');

        $db = Orders::where('user_id', $user)
                        ->join('items', 'orders.item_id', '=', 'items.id')
                        ->whereTime('created_at', '>=', NOW())
                        ->get();

        foreach ($db as $key => $value) {
           $orders = new ReceiptMail($db, $customer);
        }
        //send Mail.
        // Mail::to($customer->email)->send($orders);

        return view('thankyou', compact('db'));

        } catch(CardException $e){
            return redirect()->back()->with('status', $e->getMessage());

        } catch (Exception $e) {
            return redirect()->back()->with('status', 'An error has ocurred.');
        }
    }
}
