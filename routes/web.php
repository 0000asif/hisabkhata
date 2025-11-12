<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserPermissionController;
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

Route::get('', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('userlogin');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
    // return view('index');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('newform', [BasicController::class, 'newform']);
    Route::get('datatables', [BasicController::class, 'datatables']);

    Route::resource('area', AreaController::class);
    Route::resource('position', PositionController::class);
    Route::resource('staff', StaffController::class);
    Route::resource('loan', LoanController::class);
});

require __DIR__ . '/auth.php';
