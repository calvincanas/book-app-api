<?php

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
Route::get('/books', [\App\Http\Controllers\BooksController::class, 'index']);
Route::get('/books/{id}', [
    'as' => 'books.show',
    'uses' => '\App\Http\Controllers\BooksController@show'
]);
Route::post('/books', [\App\Http\Controllers\BooksController::class, 'store']);
Route::put('/books/{id}', [App\Http\Controllers\BooksController::class, 'update']);
Route::delete('/books/{id}', [\App\Http\Controllers\BooksController::class, 'delete']);
