<?php

use App\Http\Controllers\Api\CoupleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/mempelai', [CoupleController::class, 'index']);
Route::post('/tambah', [CoupleController::class, 'simpan']);
Route::get('/{slug}', [CoupleController::class, 'getCouple']);
Route::put('/tambah/tamu-undangan/{slug}', [CoupleController::class, 'updateTamu']);
Route::delete('/delete/{slug}', [CoupleController::class, 'hapusCouple']);
