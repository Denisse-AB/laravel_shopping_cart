<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Http\Requests\EditUserInfo;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        $auth = $request->user()->id;

        $user = User::where('id', $auth)->get();

        return view('auth.account', compact('user'));
    }

    public function update(EditUserInfo $request)
    {
        if ($request->error) {
           return $request->validated();
        }

        //table
        $request->user()->fill([
            'name' => $request->name,
            'tel' => $request->tel,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
        ])->save();

        return response()->json(null, 200);
    }

    public function put(Request $request, $user_id)
    {
        $user =User::find($user_id);

        //check current pass
        $request->validate([
            'oldPassword' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        //check current password match
        if (Hash::check($request->oldPassword, $user->password)) {

             $request->user()->fill([
                'password' => Hash::make($request->password)
            ])->save();

            return response()->json(200);

        } else {

            return response()->json([
                'error' => 403,
                'pwdErr' => 'Your password is incorrect.'
            ]);
        }
    }
}
