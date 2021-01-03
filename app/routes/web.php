<?php

use Api\Modules\UserComment\Models\UserComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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

    $comments = UserComment::orderBy('created_at', 'desc')->get();

    return view('usercomments', [
        'usercomments' => $comments
    ]);
});

Route::get('user-comment/{id}', function($id) {
    $userComment = UserComment::findOrFail($id);

    return view('commentdetails', [
        'usercomments' => $userComment
    ]);
});

Route::post('/user-comment', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'comments' => 'required',
        'password' => 'required'
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $comment = new Api\Modules\UserComment\Models\UserComment;
    $comment->name = $request->name;
    $comment->comments = $request->comments;
    $comment->save();

    return redirect('/');
});

Route::delete('/user-comment/{id}', function ($id) {
    UserComment::findOrFail($id)->delete();

    return redirect('/');
});
