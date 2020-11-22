<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopicsController;

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

Route::get('/', [PagesController::class, 'root'])->name('root');

Auth::routes(['verify' => true]);

Route::resource('users', UsersController::class, ['only' => ['show', 'update', 'edit']]);

Route::resource('topics', TopicsController::class, ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
