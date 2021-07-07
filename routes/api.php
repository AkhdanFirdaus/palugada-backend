<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WebinarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('count-pendaftar', [WebinarController::class, 'countPendaftar']);
Route::get('count-webinar', [WebinarController::class, 'countWebinar']);

Route::post('login', [UserController::class, 'login']);
Route::post('login-with-id', [UserController::class, 'loginWithId']);
Route::post('register', [UserController::class, 'register']);

Route::get('user/{id}', [UserController::class, 'showUser']);
Route::get('user/{id}/count-webinar', [WebinarController::class, 'countMyWebinar']);
Route::get('user/{id}/my-webinar', [WebinarController::class, 'myWebinar']);
Route::get('user/{id}/diikuti', [WebinarController::class, 'joinedWebinar']);

Route::get('penyelenggara', [UserController::class, 'listPenyelenggara']);

Route::resource('webinar', WebinarController::class);
Route::post('webinar/daftar', [WebinarController::class, 'daftar']);
