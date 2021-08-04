<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KJKController;

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

Auth::routes();

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('testing/create', [KJKController::class, 'createRequest'])->name('createRequest');
Route::post('testing/delete', [FirebaseController::class, 'deleteRequest'])->name('deleteRequest');
Route::post('testing/store', [FirebaseController::class, 'storeRequest'])->name('storeRequest');
Route::post('testing/update', [FirebaseController::class, 'updateRequest'])->name('updateRequest');


Route::get('testing', function () {
    return view('test');
})->name('test');

Route::get('firebase', [FirebaseController::class, 'index']);
