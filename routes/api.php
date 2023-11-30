<?php

use Illuminate\Http\Request;
use App\Http\Controllers\NotaFiscalController;
use Illuminate\Support\Facades\Route;

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

Route::resource('notas-fiscais', NotaFiscalController::class)->middleware('can:view,nota_fiscal');
