<?php

use App\Models\Member;
use App\Exports\MembersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\FdRateController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DpsPlanController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DpsAccountController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\FixedDepositController;
use App\Http\Controllers\FdrCalculatorController;
use App\Http\Controllers\IncomeExpenseController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\BankTransactionController;
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

// User Profile
Route::group(['middleware' => 'auth'], function() {
    Route::get('/profile', [AdminController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [AdminController::class, 'update'])->name('profile.update');
});


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

    Route::get('/loan/{id}/installments', [LoanController::class, 'installments'])
     ->name('loan.installments');


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
    Route::get('/dps-calculator', [DpsAccountController::class, 'index'])->name('dps.calculator.index');
    Route::post('/dps-calculator', [DpsAccountController::class, 'calculate'])->name('dps.calculate');

    // DPS WITHDRAW
    Route::get('/dps/withdraw/{id}', [DpsPlanController::class, 'withdraw'])->name('dps.withdraw');

    Route::resource('category',CategoryController::class);
    Route::resource('income-expense', IncomeExpenseController::class);
    Route::get('/income-expense-report', [IncomeExpenseController::class, 'report'])
    ->name('income-expense.report');

    /*
    |--------------------------------------------------------------------------
    | BANK ACCOUNT ROUTES (CRUD)
    |--------------------------------------------------------------------------
    */
    Route::resource('bank', BankAccountController::class);


    /*
    |--------------------------------------------------------------------------
    | BANK TRANSACTION ROUTES (Deposit / Withdraw)
    |--------------------------------------------------------------------------
    */
    Route::get('bank-transaction/create', [BankTransactionController::class, 'create'])
        ->name('bank-transaction.create');

    Route::post('bank-transaction/store', [BankTransactionController::class, 'store'])
        ->name('bank-transaction.store');

    Route::get('bank-transaction', [BankTransactionController::class, 'index'])
        ->name('bank-transaction.index');


    /*
    |--------------------------------------------------------------------------
    | BANK TRANSFER ROUTES (Bank → Bank)
    |--------------------------------------------------------------------------
    */
    Route::get('bank-transfer', [BankTransactionController::class, 'transferForm'])
        ->name('bank-transfer.form');

    Route::post('bank-transfer/store', [BankTransactionController::class, 'transfer'])
        ->name('bank-transfer.store');


    /*
    |--------------------------------------------------------------------------
    | BANK REPORT ROUTE
    |--------------------------------------------------------------------------
    */
    Route::get('bank-report', [BankAccountController::class, 'bankReport'])
        ->name('bank.report');

        // 1. Loan Summary
        Route::get('/report/loans', [ReportController::class, 'loanSummary'])->name('report.loans');

        // 2. Installments Report
        Route::get('/report/installments', [ReportController::class, 'installments'])->name('report.installments');

        // 3. Daily Collection
        Route::get('/report/collection/daily', [ReportController::class, 'dailyCollection'])->name('report.collection.daily');

        // 4. Member-wise Report
        Route::get('/report/member', [ReportController::class, 'memberReport'])->name('report.member');

        // 5. Area-wise Report
        Route::get('/report/area', [ReportController::class, 'areaReport'])->name('report.area');

        // 6. Late Fee Report
        Route::get('/report/latefee', [ReportController::class, 'lateFee'])->name('report.latefee');

        // 7. Late Fee Collection History
        Route::get('/report/latefee/collection', [ReportController::class, 'lateFeeCollection'])->name('report.latefee.collection');

        
        Route::get('/fdr-calculator', [FdrCalculatorController::class, 'index'])->name('fdr.calculator');
        Route::post('/fdr-calc', [FdrCalculatorController::class, 'calculate'])->name('fdr.calculate');
    
        Route::get('/savings/report', [SavingsController::class, 'reportForm'])->name('savings.report.form');
        Route::get('/savings/report/data', [SavingsController::class, 'report'])->name('savings.report');

        
        Route::get('/fds/reports', [FixedDepositController::class, 'reportForm'])->name('fd.report.form');
        Route::get('/fds/reports/search', [FixedDepositController::class, 'report'])->name('fd.report');
        Route::get('/dps/report', [DpsPlanController::class, 'reportForm'])->name('dps.report.form');
        Route::get('/dps/report/search', [DpsPlanController::class, 'report'])->name('dps.report');
        

        Route::get('/income-expense/report', [IncomeExpenseController::class, 'report'])->name('income-expense.reportss');

       
        
        Route::get('/members/export', function () {
            return Excel::download(new MembersExport, 'members_full.xlsx');
        })->name('member.export');

        Route::get('/loans/print', [LoanController::class, 'print'])->name('loans.print');

});


require __DIR__ . '/auth.php';
