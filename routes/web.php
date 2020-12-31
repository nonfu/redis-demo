<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
})->middleware('throttle:10,1');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/broadcast', function () {
    return view('websocket');
});

Route::get('/groups/{id}/enter', function ($id) {
    return view('group', ['name' => request()->user()->name, 'id' => $id]);
})->middleware('throttle:');

Route::post('/groups/{id}/enter', function ($id) {
    broadcast(new \App\Events\UserEnterGroup(request()->user(), $id))->toOthers();
    return true;
});

Route::get('/posts/create', [PostController::class, 'create']);
Route::post('/posts/store', [PostController::class, 'store']);

Route::get('/posts/{id}', [PostController::class, 'show']);

// Session
Route::get('/session', function (\Illuminate\Http\Request $request) {
    \session()
    $request->session()->put('name', '学院君');
    $name = $request->session()->get('name');
    dd($name);
});


