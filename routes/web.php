<?php

use App\Http\Controllers\AllocationController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParticipantController;
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

Route::get('/dashboard', DashboardController::class)->middleware(['auth', '2fam'])->name('dashboard');

Route::middleware(['auth', '2fam'])->group(function () {
    Route::resource('/participants', ParticipantController::class);
    Route::resource('/businesses', BusinessController::class);
    Route::resource('/allocations', AllocationController::class);
    Route::resource('/claims', ClaimController::class);
    Route::get('/manage/xero', [\App\Http\Controllers\XeroController::class, 'index'])->name('xero.auth.success');
    Route::get('/test', [\App\Http\Controllers\XeroController::class, 'test'])->name('xero.test');

    Route::get('/2fa', [\App\Http\Controllers\TwoFAController::class, 'index'])->name('2fa.index');
});

Route::get('/verify', [AllocationController::class, 'verify'])->name('verify');

require __DIR__.'/auth.php';
