<?php

use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('landing-page');
// });

// Route::get('/kontak', function () {
//     return view('kontak');
// });
// Route::get('/visimisi', function () {
//     return view('visimisi');
// });


Route::get('/login', 'App\Http\Controllers\LoginController@index')->name('login');
Route::post('/login', 'App\Http\Controllers\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\LoginController@logout')->name('logout');

Route::prefix('/')->middleware('auth')->group(function () {
    Route::get('/', 'App\Http\Controllers\DashboardController@index');
    Route::get('/setting', 'App\Http\Controllers\DashboardController@inSetting');
    Route::post('/setStore', 'App\Http\Controllers\DashboardController@setStore');

    Route::group(['prefix' => 'data_siswa', 'as' => 'data-siswa.'], function () {
        Route::get('/print', 'App\Http\Controllers\PdfControllerds@generatePDF')->name('print');
        Route::get('/print/{id}', 'App\Http\Controllers\PdfController@generatePDFOne')->name('print.one');
    });

    Route::group(['prefix' => 'barang', 'as' => 'barang.'], function () {
        Route::get('/print', 'App\Http\Controllers\PdfController@generatePDF')->name('print');
        Route::get('/print/{id}', 'App\Http\Controllers\PdfController@generatePDFOne')->name('print.one');
    });

    Route::group(['prefix' => 'kaskecil', 'as' => 'kaskecil.'], function () {
        Route::get('/print', 'App\Http\Controllers\PdfControllerkk@generatePDF')->name('print');
    });

    Route::group(['prefix' => 'tabungan', 'as' => 'tabungan.'], function () {
        Route::get('/print', 'App\Http\Controllers\PdfControllertb@generatePDF')->name('print');
    });
    Route::group(['prefix' => 'realisasianggaran', 'as' => 'realisasianggaran.'], function () {
        Route::get('/print', 'App\Http\Controllers\PdfControllerra@generatePDF')->name('print');
    });
    Route::group(['prefix' => 'tabungan-bni', 'as' => 'tabungan-bni.'], function () {
        Route::get('/print', 'App\Http\Controllers\PdfControllertbni@generatePDF')->name('print');
    });

    Route::prefix('/comodities')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\ComodityController@index');
        Route::post('/store', 'App\Http\Controllers\ComodityController@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\ComodityController@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\ComodityController@update');
        Route::get('/show/{id}', 'App\Http\Controllers\ComodityController@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\ComodityController@destroy');

        Route::get('/export', 'App\Http\Controllers\ComodityController@export');
        Route::post('/import', 'App\Http\Controllers\ComodityController@import')->name('import');
    });

    Route::prefix('/comodity_locations')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\ComodityLocations@index');
        Route::post('/store', 'App\Http\Controllers\ComodityLocations@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\ComodityLocations@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\ComodityLocations@update');
        Route::get('/show/{id}', 'App\Http\Controllers\ComodityLocations@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\ComodityLocations@destroy');
    });

    Route::prefix('/school_operationals')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\SchoolOperationals@index');
        Route::post('/store', 'App\Http\Controllers\SchoolOperationals@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\SchoolOperationals@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\SchoolOperationals@update');
        Route::get('/show/{id}', 'App\Http\Controllers\SchoolOperationals@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\SchoolOperationals@destroy');
    });


    Route::prefix('/data_siswa')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\DataSiswaController@index');
        Route::post('/store', 'App\Http\Controllers\DataSiswaController@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\DataSiswaController@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\DataSiswaController@update');
        Route::get('/show/{id}', 'App\Http\Controllers\DataSiswaController@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\DataSiswaController@destroy');
    });



    Route::prefix('/data_pengajar')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\DataPengajarController@index');
        Route::post('/store', 'App\Http\Controllers\DataPengajarController@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\DataPengajarController@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\DataPengajarController@update');
        Route::get('/show/{id}', 'App\Http\Controllers\DataPengajarController@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\DataPengajarController@destroy');
    });


    Route::prefix('/kaskecil')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\KasKecilController@index');
        Route::post('/store', 'App\Http\Controllers\KasKecilController@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\KasKecilController@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\KasKecilController@update');
        Route::get('/show/{id}', 'App\Http\Controllers\KasKecilController@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\KasKecilController@destroy');

        Route::get('/export', 'App\Http\Controllers\KasKecilController@export');
        Route::post('/import', 'App\Http\Controllers\KasKecilController@import')->name('import');
    });
    Route::prefix('/mataanggaran')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\MataAnggaranController@index');
        Route::post('/store', 'App\Http\Controllers\MataAnggaranController@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\MataAnggaranController@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\MataAnggaranController@update');
        Route::get('/show/{id}', 'App\Http\Controllers\MataAnggaranController@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\MataAnggaranController@destroy');
    });

    Route::prefix('/kode-transaksi-bni')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\KodeBniController@index');
        Route::post('/store', 'App\Http\Controllers\KodeBniController@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\KodeBniController@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\KodeBniController@update');
        Route::get('/show/{id}', 'App\Http\Controllers\KodeBniController@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\KodeBniController@destroy');
    });
    Route::prefix('/kodebri')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\KodeBriController@index');
        Route::post('/store', 'App\Http\Controllers\KodeBriController@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\KodeBriController@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\KodeBriController@update');
        Route::get('/show/{id}', 'App\Http\Controllers\KodeBriController@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\KodeBriController@destroy');
    });
    Route::prefix('/tabungan')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\TabunganController@index');
        Route::post('/store', 'App\Http\Controllers\TabunganController@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\TabunganController@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\TabunganController@update');
        Route::get('/show/{id}', 'App\Http\Controllers\TabunganController@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\TabunganController@destroy');

        Route::get('/export', 'App\Http\Controllers\TabunganController@export');
        Route::post('/import', 'App\Http\Controllers\TabunganController@import')->name('import');
    });

    Route::prefix('/kategoritabungan')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\KategoriTabunganController@index');
        Route::post('/store', 'App\Http\Controllers\KategoriTabunganController@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\KategoriTabunganController@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\KategoriTabunganController@update');
        Route::get('/show/{id}', 'App\Http\Controllers\KategoriTabunganController@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\KategoriTabunganController@destroy');

        Route::get('/export', 'App\Http\Controllers\TabunganController@export');
        Route::post('/import', 'App\Http\Controllers\TabunganController@import')->name('import');
    });

    Route::prefix('/jenis-transaksi-tabungan')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\JenisTransaksiTabunganController@index');
        Route::post('/store', 'App\Http\Controllers\JenisTransaksiTabunganController@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\JenisTransaksiTabunganController@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\JenisTransaksiTabunganController@update');
        Route::get('/show/{id}', 'App\Http\Controllers\JenisTransaksiTabunganController@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\JenisTransaksiTabunganController@destroy');

        Route::get('/export', 'App\Http\Controllers\JenisTransaksiTabunganController@export');
        Route::post('/import', 'App\Http\Controllers\JenisTransaksiTabunganController@import')->name('import');
    });
    Route::prefix('/realisasianggaran')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\RealisasiAnggaranController@index');
        Route::post('/store', 'App\Http\Controllers\RealisasiAnggaranController@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\RealisasiAnggaranController@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\RealisasiAnggaranController@update');
        Route::get('/show/{id}', 'App\Http\Controllers\RealisasiAnggaranController@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\RealisasiAnggaranController@destroy');

        Route::get('/export', 'App\Http\Controllers\RealisasiAnggaranController@export');
        Route::post('/import', 'App\Http\Controllers\RealisasiAnggaranController@import')->name('import');
    });
    Route::prefix('/tabungan-bni')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\TabunganBniController@index');
        Route::post('/store', 'App\Http\Controllers\TabunganBniController@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\TabunganBniController@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\TabunganBniController@update');
        Route::get('/show/{id}', 'App\Http\Controllers\TabunganBniController@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\TabunganBniController@destroy');

        Route::get('/export', 'App\Http\Controllers\TabunganBniController@export');
        Route::post('/import', 'App\Http\Controllers\TabunganBniController@import')->name('import');
    });
    Route::prefix('/tabunganbri')->middleware('auth')->group(function () {
        Route::get('/', 'App\Http\Controllers\TabunganBriController@index');
        Route::post('/store', 'App\Http\Controllers\TabunganBriController@store');
        Route::get('/edit/{id}', 'App\Http\Controllers\TabunganBriController@edit');
        Route::put('/update/{id}', 'App\Http\Controllers\TabunganBriController@update');
        Route::get('/show/{id}', 'App\Http\Controllers\TabunganBriController@show');
        Route::delete('/destroy/{id}', 'App\Http\Controllers\TabunganBriController@destroy');

        Route::get('/export', 'App\Http\Controllers\TabunganBniController@export');
        Route::post('/import', 'App\Http\Controllers\TabunganBniController@import')->name('import');
    });
});
