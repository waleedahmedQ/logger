<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimeLogController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('logs', TimeLogController::class);
    Route::get('/log/{log}', [TimeLogController::class, 'destroy'])->name('logs.destroy');
    Route::get('/log/summary/report',[TimeLogController::class, 'summary'])->name('log.summary');
    Route::get('/log/summary/report/download',[TimeLogController::class, 'downloadExcel'])->name('log.download');

});

require __DIR__.'/auth.php';
