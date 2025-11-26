<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\TargetWeightController;

Route::get('/register/step1', [RegisterController::class, 'showStep1'])->name('register.step1');
Route::post('/register/step1', [RegisterController::class, 'postStep1'])->name('register.step1.post');
Route::get('/register/step2', [RegisterController::class, 'showStep2'])->name('register.step2.show');
Route::post('/register/step2', [RegisterController::class, 'storeStep2'])->name('register.step2');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::middleware('auth')->group(function () {
Route::get('/weight_logs', [AdminController::class, 'index'])->name('weight_logs.index');
Route::get('/weight_logs/{weightLog}', [WeightLogController::class, 'show'])->name('weight_logs.show');
Route::get('/wight_logs/goal_setting', [TargetWeightController::class, 'edit'])->name('goal_setting.edit');
Route::post('/wight_logs/goal_setting', [TargetWeightController::class, 'update'])->name('goal_setting.update');
Route::post('/records', [RecordController::class, 'store'])->name('records.store');
Route::get('/records/{record}/edit', [RecordController::class, 'edit'])->name('records.edit');
Route::put('/records/{record}', [RecordController::class, 'update'])->name('records.update');
Route::delete('/records/{record}', [RecordController::class, 'destroy'])->name('records.destroy');
Route::post('/logout', function () {Auth::logout();
        return redirect('/login');
    })->name('logout');
});
