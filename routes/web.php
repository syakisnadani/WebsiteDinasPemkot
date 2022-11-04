<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PresentController;
use App\Http\Controllers\TimeController;

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

Route::get('/login', function () {
    return view('auth.login');
})->middleware(['auth']);

// test page print
Route::get('/print', function () {
    return view('printPresent');
})->middleware(['auth']);

Route::get('/register', function () {
    return view('auth.register');
})->middleware(['auth']);

Route::get('/dashboard', function () {
    return view('welcome');
});

Route::get('/unauthorized', function () {
    return view('unauthorized');
});

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/staff', [StaffController::class, 'index'])->middleware(['auth'])->name('indexStaff');
Route::get('/addStaff', [StaffController::class, 'create'])->middleware(['auth'])->name('createStaff');
Route::get('/showStaff/{id}', [StaffController::class, 'show'])->middleware(['auth'])->name('showStaff');
Route::get('/destroyStaff/{id}', [StaffController::class, 'destroy'])->middleware(['auth'])->name('destroyStaff');
Route::post('/storeStaff', [StaffController::class, 'store'])->middleware(['auth'])->name('storeStaff');
Route::post('/updateStaff/{id}', [StaffController::class, 'update'])->middleware(['auth'])->name('updateStaff');

Route::get('/present', [PresentController::class, 'index'])->middleware(['auth'])->name('indexPresent');
Route::get('/manualPresent', [PresentController::class, 'indexManual'])->middleware(['auth'])->name('indexManualPresent');
Route::get('/uploadPresent', [PresentController::class, 'create'])->middleware(['auth'])->name('uploadPresent');
Route::get('/showDatePresent/{id}/{date}', [PresentController::class, 'showDate'])->middleware(['auth'])->name('showDatePresent');
Route::post('/showManualPresent', [PresentController::class, 'showManual'])->middleware(['auth'])->name('showManualPresent');
Route::post('/showPresent', [PresentController::class, 'show'])->middleware(['auth'])->name('showPresent');
Route::post('/storePresent', [PresentController::class, 'store'])->middleware(['auth'])->name('storePresent');
Route::post('/updateManualDate/{pin}', [PresentController::class, 'storeManual'])->middleware(['auth'])->name('storeManualPresent');

Route::get('/jamKerja', [TimeController::class, 'index'])->middleware(['auth'])->name('indexKerja');
Route::get('/addKerja', [TimeController::class, 'create'])->middleware(['auth'])->name('createKerja');
Route::get('/showKerja/{id}', [TimeController::class, 'show'])->middleware(['auth'])->name('showKerja');
Route::get('/destroyKerja/{id}', [TimeController::class, 'destroy'])->middleware(['auth'])->name('destroyKerja');
Route::post('/storeKerja', [TimeController::class, 'store'])->middleware(['auth'])->name('storeKerja');
Route::post('/updateKerja/{id}', [TimeController::class, 'update'])->middleware(['auth'])->name('updateKerja');

//contact person---------------------------------------------------------------------

Route::get('/help', function () {
    return view('help');
})->middleware(['auth'])->name('help');

//admin---------------------------------------------------------------------

Route::get('/users', function () {
    return view('user_admin');
})->middleware(['auth'])->name('user_admin');

//upload---------------------------------------------------------------------

Route::get('/upload', function () {
    return view('upload.upload_files');
})->middleware(['auth'])->name('upload.upload_files');

Route::get('/database', function () {
    return view('upload.upload_database');
})->middleware(['auth'])->name('upload.upload_database');

//download---------------------------------------------------------------------

Route::get('view', 'FileController@view');
Route::get('get/{filename}', 'App\Http\Controllers\FileController@getFile')->name('getfile');
Route::get('download/{filename}', 'App\Http\Controllers\FileController@getDownload')->name('getdownload');

//notes---------------------------------------------------------------------

Route::get('/notes', function () {
    return view('notes');
})->middleware(['auth'])->name('notes');

//stock---------------------------------------------------------------------

Route::get('/stock', function () {
    return view('stock.stock');
})->middleware(['auth'])->name('stock.stock');

Route::get('/stock_alt', function () {
    return view('stock.stock_alt');
})->middleware(['auth'])->name('stock.stock_alt');

Route::get('/stock/keluar', function () {
    return view('stock.stock_keluar');
})->middleware(['auth'])->name('stock.stock_keluar');

Route::get('/stock/masuk', function () {
    return view('stock.stock_masuk');
})->middleware(['auth'])->name('stock.stock_masuk');

//asset---------------------------------------------------------------------

Route::get('/asset', function () {
    return view('asset.asset');
})->middleware(['auth'])->name('asset.asset');

Route::get('/asset/keluar', function () {
    return view('asset.asset_keluar');
})->middleware(['auth'])->name('asset.asset_keluar');

Route::get('/asset/masuk', function () {
    return view('asset.asset_masuk');
})->middleware(['auth'])->name('asset.asset_masuk');

require __DIR__.'/auth.php';