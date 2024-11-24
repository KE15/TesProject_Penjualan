<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PenjualanController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/customer', [CustomerController::class, 'showCustomer'])->name('showCustomer');
Route::post('/customer', [CustomerController::class, 'addCustomer'])->name('addCustomer');
Route::put('/customer', [CustomerController::class, 'updateCustomer'])->name('updateCustomer');
Route::delete('/customer', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');

Route::get('/penjualan/{noFaktur}', [PenjualanController::class, 'showFormPenjualan'])->name('showFormPenjualanDetail');
Route::get('/penjualan', [PenjualanController::class, 'showFormPenjualan'])->name('showFormPenjualan');
Route::post('/penjualan', [PenjualanController::class, 'addPenjualan'])->name('addPenjualan');

Route::post('/penjualan-detail', [PenjualanController::class, 'addPenjualanDetail'])->name('addPenjualanDetail');
