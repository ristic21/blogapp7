<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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
Route::get('/createpost', function () {
    return view('createpost');
});
Route::get('/about', function () {
    return view('about');
});


Route::get('/posts', [PostController::class, 'index'])->middleware('auth');
Route::get('/posts/{id}', [PostController::class, 'show'])->middleware('auth');

Route::post('/createpost', [PostController::class, 'store']);
Route::post('/createcomment', [CommentController::class, 'store']);

Route::get('signup', [AuthController::class, 'getSignUp']);
Route::get('signin', [AuthController::class, 'getSignIn']);
Route::get('signout', [AuthController::class, 'signout']);
Route::post('/signup', [AuthController::class, 'signUp']);
Route::post('/signin', [AuthController::class, 'signin']);

Route::get('/admindashboard', [PostController::class, 'index2'])->middleware('auth')->middleware('authAdmin');
Route::get('/deletepost/{id}', [PostController::class, 'destroy']);

Route::get('/deletedposts', [PostController::class, 'index3'])->middleware('auth')->middleware('authAdmin');
Route::get('/editpost', [PostController::class, 'showEdit']);
Route::post('/editpost/{id}', [PostController::class, 'update']);