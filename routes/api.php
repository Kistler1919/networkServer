<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StatusUpdateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFileController;
// use Illuminate\Http\Request;
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


Route::get('posts', [PostController::class, 'index']);
Route::get('user/experiences', [ExperienceController::class, 'index']);
Route::get('user/houses', [HouseController::class, 'index']);
Route::get('events', [ActivityController::class, 'index']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('activate_email/{code}', [AuthController::class, 'activateEmail']);

    Route::post('forgot_password', [AuthController::class, 'forgotPassword']);
    Route::post('forgot_password/{token}', [AuthController::class, 'resetPasswordToken']);

    Route::group([
        'middleware' => 'auth:api',
    ], function() {
        // TODO: password reset
    });
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'user'
], function() {
    Route::get('me', [UserController::class, 'me']);
    Route::post('status/new', [StatusUpdateController::class, 'store']);
    Route::get('status/new', [StatusUpdateController::class, 'index']);
    Route::post('posts/new', [PostController::class, 'store']);
    Route::get('posts/new', [PostController::class, 'index']);
    Route::post('image-upload', [UserFileController::class, 'store']);
    Route::get('add_friend/{id}', [UserFileController::class, 'addFriend']);
});

Route::group([
    'middleware' => 'auth:admins',
    'prefix' => 'admin'
], function() {
    Route::post('user/houses', [HouseController::class, 'store']);
    Route::post('events', [ActivityController::class, 'store']);
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
