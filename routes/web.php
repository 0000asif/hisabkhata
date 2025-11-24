<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\DpsPlanController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\FixedDepositController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;



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

Route::get('dashboard', [AdminController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('newform', [BasicController::class, 'newform']);
    Route::get('datatables', [BasicController::class, 'datatables']);

    Route::resource('area', AreaController::class);
    Route::resource('position', PositionController::class);
    Route::resource('staff', StaffController::class);
    // Route::resource('loan', LoanController::class);
    Route::resource('branch', BranchController::class);
    Route::resource('member', MemberController::class);

    // Loan Module
    Route::prefix('loan')->name('loan.')->group(function () {

        Route::get('/', [LoanController::class, 'index'])->name('index');

        Route::get('/create', [LoanController::class, 'create'])->name('create');
        Route::post('/store', [LoanController::class, 'store'])->name('store');

        Route::get('/details/{id}', [LoanController::class, 'details'])->name('details');
    });

    // Loan Collection
    Route::prefix('collection')->name('collection.')->group(function () {

        // All Member Collection List
        Route::get('/all', [CollectionController::class, 'allMembers'])->name('all');
        Route::get('/', [CollectionController::class, 'index'])->name('index');
        Route::post('/load', [CollectionController::class, 'load'])->name('load');
        Route::post('/pay/{id}', [CollectionController::class, 'pay'])->name('pay');
    });

    Route::prefix('members')->name('member.')->group(function () {
        Route::get('/ledger', [LedgerController::class, 'memberLedgerIndex'])->name('ledger.index'); // select member
        Route::get('/ledger/{id}', [LedgerController::class, 'memberLedger'])->name('ledger'); // show ledger
    });


    Route::prefix('loan')->name('loan.')->group(function () {
        Route::get('/ledger', [LedgerController::class, 'loanLedger'])->name('ledger');
    });

    Route::prefix('savings')->name('savings.')->group(function () {
        Route::get('/all', [SavingsController::class, 'index'])->name('index');
        Route::get('/collect', [SavingsController::class, 'collectForm'])->name('collect.form');
        Route::post('/collect', [SavingsController::class, 'collect'])->name('collect');

        Route::get('/transaction/{id}', [SavingsController::class, 'transactions'])->name('transactions');

        Route::post('/withdraw/{id}', [SavingsController::class, 'withdraw'])->name('withdraw');
    });


    Route::get('/fd/get-rate/{months}', [FixedDepositController::class, 'getRate']);
    Route::resource('fd', FixedDepositController::class);
    Route::post('/fd/{id}/withdraw', [FixedDepositController::class, 'withdraw'])->name('fd.withdraw');

    // FD Rate CRUD
    Route::prefix('fd/rate')->name('fd.rate.')->group(function () {

        Route::get('/', [App\Http\Controllers\FdRateController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\FdRateController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\FdRateController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [App\Http\Controllers\FdRateController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [App\Http\Controllers\FdRateController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [App\Http\Controllers\FdRateController::class, 'destroy'])->name('delete');
    });

    // Ajax Rate
    Route::get('/fd/get-rate/{months}', [App\Http\Controllers\FdRateController::class, 'getRate']);



    // DPS PLAN
    Route::get('/dps/plans', [DpsPlanController::class, 'planIndex'])->name('dps.plan.index');
    Route::get('/dps/plans/create', [DpsPlanController::class, 'planCreate'])->name('dps.plan.create');
    Route::post('/dps/plans/store', [DpsPlanController::class, 'planStore'])->name('dps.plan.store');

    // DPS ACCOUNT
    Route::get('/dps/accounts', [DpsPlanController::class, 'accountIndex'])->name('dps.account.index');
    Route::get('/dps/accounts/create', [DpsPlanController::class, 'accountCreate'])->name('dps.account.create');
    Route::post('/dps/accounts/store', [DpsPlanController::class, 'accountStore'])->name('dps.account.store');

    // DPS DETAILS
    Route::get('/dps/accounts/{id}', [DpsPlanController::class, 'accountShow'])->name('dps.account.show');

    // DPS INSTALLMENT PAY
    Route::post('/dps/installment/pay/{id}', [DpsPlanController::class, 'payInstallment'])->name('dps.pay');

    // DPS WITHDRAW
    Route::get('/dps/withdraw/{id}', [DpsPlanController::class, 'withdraw'])->name('dps.withdraw');
});


require __DIR__ . '/auth.php';
