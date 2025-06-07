
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeranjangController;

Route::delete('/keranjang', [KeranjangController::class, 'removeByProduct'])->middleware('auth:sanctum');
