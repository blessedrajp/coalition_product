<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[ProductController::class,'index'])->name('product.index');
Route::get('/add',[ProductController::class,'add'])->name('product.add');
Route::post('/store',[ProductController::class,'store'])->name('product.store');
// Route for fetching data for the table
Route::get('/get-data', [ProductController::class, 'getDataForTable'])->name('product.data');

