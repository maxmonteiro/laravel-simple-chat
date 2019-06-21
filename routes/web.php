<?php
use App\Message;
use App\Events\MessageSent;

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

Route::get('/', function () {
    return view('welcome');
});

// Return all messages that will populate the chat
Route::get('/getAll', function() {
    $messages = Message::take(200)->pluck('content');
    return $messages;
});

// Post new message
Route::post('/post', function() {
    $message = new Message();

    $content = request('message');
    $message->content = $content;

    $message->save();

    // Broadcast event
    event(new MessageSent($content));

    return $content;
});

