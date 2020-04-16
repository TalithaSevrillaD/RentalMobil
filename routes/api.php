<?php

use Illuminate\Http\Request;

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
Route::post('register', 'Petugascontroller@register');
Route::post('login', 'Petugascontroller@login');
Route::get('/', function(){
    return Auth::user()->level;
})->middleware('jwt.verify');
Route::put('petugas/{id}', 'Petugascontroller@update')->middleware('jwt.verify');
Route::delete('petugas/{id}', 'Petugascontroller@destroy')->middleware('jwt.verify');
Route::get('petugas', 'Petugascontroller@show')->middleware('jwt.verify');

Route::post('penyewa', 'Penyewacontroller@store')->middleware('jwt.verify');
Route::put('penyewa/{id}', 'Penyewacontroller@update')->middleware('jwt.verify');
Route::delete('penyewa/{id}', 'Penyewacontroller@destroy')->middleware('jwt.verify');
Route::get('penyewa', 'Penyewacontroller@show')->middleware('jwt.verify');

Route::post('jenis', 'Jeniscontroller@store')->middleware('jwt.verify');
Route::put('jenis/{id}', 'Jeniscontroller@update')->middleware('jwt.verify');
Route::delete('jenis/{id}', 'Jeniscontroller@destroy')->middleware('jwt.verify');
Route::get('jenis', 'Jeniscontroller@show')->middleware('jwt.verify');

Route::post('data_mobil', 'Datacontroller@store')->middleware('jwt.verify');
Route::put('data_mobil/{id}', 'Datacontroller@update')->middleware('jwt.verify');
Route::delete('data_mobil/{id}', 'Datacontroller@destroy')->middleware('jwt.verify');
Route::get('data_mobil', 'Datacontroller@show')->middleware('jwt.verify');