<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/addBuku', [BukuController::class, 'addBuku'])->name('addBuku');
Route::put('/updateBuku/{id}', [BukuController::class, 'updateBuku'])->name('updateBuku');
Route::delete('/deleteBuku/{id}', [BukuController::class, 'deleteBuku'])->name('deleteBuku');
Route::get('/listBuku', [BukuController::class, 'listBuku'])->name('listBuku');
