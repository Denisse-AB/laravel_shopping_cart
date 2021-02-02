<?php

use App\Items;
use App\Mail\ReceiptMail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Sample\CaptureIntentExamples\CreateOrder;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//email view.
Route::get('/email', function() {
    return new ReceiptMail();
});

Route::get('/lang/{lang}', function ($lang) {
    App::setlocale($lang);
    $items = Items::all()->shuffle();
    return view('index', compact('items'));
});

Route::get('/', 'ItemsController@index')->name('items.index');

Route::get('/items/{item}/{lang}', 'ItemsController@show')->name('items.show');

Route::post('/item/{item_id}/{lang}', 'SessionController@store')->name('items.store');

Route::get('/cart/{lang}', 'SessionController@show')->name('cart.show');

Route::delete('/item/{id}', 'SessionController@delete')->name('item.destroy');

Auth::routes();

Route::get('/wishlist', 'SaveForLaterController@show')->name('wishlist.show');

Route::get('/account/{lang}', 'UserController@show')->name('account.show');

Route::get('/checkout/{lang}', 'CheckoutController@show')->name('checkout.show');

Route::post(
    'stripe/webhook',
    '\App\Http\Controllers\WebhookController@handleWebhook'
);

Route::put('/passwordEdit/{user_id}', 'UserController@put')->name('password.update');

Route::patch('/userEdit/{id}', 'UserController@update')->name('user.update');

Route::get('/comments/{item}', 'CommentsController@show')->name('comments.show');

Route::post('/comment/{item}', 'CommentsController@store')->name('comments.store');

Route::delete('/deleteComment/{comment_id}', 'CommentsController@delete')->name('comments.destroy');

Route::patch('/update/{comment_id}', 'CommentsController@update')->name('comment.update');

Route::post('/reply/{comment_id}', 'RepliesController@store')->name('reply.store');

Route::delete('/deleteReply/{reply_id}', 'RepliesController@delete')->name('reply.destroy');

Route::delete('/wishlist/{item_id}', 'SaveForLaterController@delete')->name('wishlist.destroy');

Route::post('/saveForLater/{item}', 'SaveForLaterController@store')->name('saveForLater.store');

Route::post('/charge/{user}', 'CheckoutController@store')->name('order.store');