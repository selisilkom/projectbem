<?php

use Illuminate\Support\Facades\Mail;
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

Route::middleware(['siswa.petugas.guest'])->group(function () {
    Route::get('/mahasiswa/login', 'Auth\Mahasiswa\LoginController@showLoginForm');
    Route::post('/mahasiswa/login', 'Auth\Mahasiswa\LoginController@login');
});
