<?php

use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ServiceController;
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

Route::apiResource('services',ServiceController::class);
Route::apiResource('groups',GroupController::class);
Route::apiResource('messages',MessageController::class);
Route::get('messages/private-conversation',[MessageController::class,'privateConversation'])->name('get-private-conversation');
Route::get('messages/group-conversation',[MessageController::class,'groupConversation'])->name('get-group-conversation');
