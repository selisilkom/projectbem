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

Route::middleware(['auth.adminsiswa'])->group(function () {
    Route::get('/', 'Admin\HomeController@index');

    // Siswa
    Route::get('/mahasiswa/organisasi/{id_organisasi}', 'Admin\MahasiswaController@index');
    Route::post('/mahasiswa/organisasi/{id_organisasi}/action-import-mahasiswa', 'Admin\MahasiswaController@import');
    Route::get('/mahasiswa/download-format-mahasiswa', 'Admin\MahasiswaController@formatImport');
    Route::get('/mahasiswa/organisasi/{id_organisasi}/create', 'Admin\MahasiswaController@create');
    Route::get('/mahasiswa/{nim}/lihat-iuran', 'Admin\MahasiswaController@lihatIuran');
    Route::get('/mahasiswa/{nim}/bayar/{id_iuran}/{semester}/create', 'Admin\MahasiswaController@createPembayaranIuran');
    Route::get('/mahasiswa/{nim}/bayar/{id_iuran}/{semester}/email-notification', 'Admin\MahasiswaController@emailNotification');
    Route::post('/mahasiswa/{nim}/bayar/{id_iuran}/{semester}', 'Admin\MahasiswaController@storePembayaranIuran');
    Route::get('/mahasiswa/{nim}/bayar/{id_iuran}/{semester}/{id_pembayaran}', 'Admin\MahasiswaController@editPembayaranIuran');
    Route::put('/mahasiswa/{nim}/bayar/{id_iuran}/{semester}/{id_pembayaran}', 'Admin\MahasiswaController@UpdatePembayaranIuran');
    Route::get('/histori-pembayaran', 'Admin\HistoriPembayaranController@index');
    Route::get('/histori-pembayaran/cetak/index', 'Admin\HistoriPembayaranController@cetakIndex');
    Route::get('/histori-pembayaran/{id_log_pembayaran}', 'Admin\HistoriPembayaranController@show');
    Route::get('/histori-pembayaran/{id_log_pembayaran}/kuitansi', 'Admin\HistoriPembayaranController@showKuitansi');
    Route::get('/histori-pembayaran/mahasiswa/{nim}', 'Admin\HistoriPembayaranController@showByNim');
    Route::get('/histori-pembayaran/mahasiswa/{id_pembayaran}/pembayaran', 'Admin\HistoriPembayaranController@showByPembayaranId');
    Route::get('/mahasiswa/{id_organisasi}/create', 'Admin\MahasiswaController@create');
    Route::resource('/mahasiswa', 'Admin\MahasiswaController');
    // Route::resource('/tahun-akademik', 'Admin\TahunAkademikController');
    Route::resource('/pengeluaran', 'Admin\PengeluaranController');
    Route::resource('/organisasi', 'Admin\OrganisasiController');
    Route::resource('/iuran', 'Admin\IuranController');
    Route::resource('/petugas', 'Admin\PetugasController');
    Route::post('/logout', 'Auth\Admin\LoginController@logout');

    Route::resource('/tahun-ajaran', 'Admin\TahunAjaranController');
    Route::put('/tahun-ajaran/{encId}/set-active', 'Admin\TahunAjaranController@setActive');
});

// Login 
Route::middleware(['siswa.petugas.guest'])->group(function () {
    Route::get('/login', 'Auth\Admin\LoginController@showLoginForm');
    Route::post('/login', 'Auth\Admin\LoginController@login');
});
