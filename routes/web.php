<?php

use App\Http\Controllers\admin\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\FileController;
use App\Http\Controllers\admin\FinancialFundController;
use App\Http\Controllers\admin\ExpenditureController;
use App\Http\Controllers\admin\LoanFundController;
use App\Http\Controllers\admin\DollarAmountController;
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
})->name('home');

Auth::routes([
    'register'=>false,
    'verification.resend'=>false,
    'password.confirm'=>false,
    'password.email'=>false,
    'password.update'=>false,
]);

Route::group(['middleware'=>'auth'], function (){
    Route::group([
        'prefix'=>'admin',
        'middleware'=>'is_admin',
        'as'=>'admin.',
    ],function (){

        //users
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/user_activity', [App\Http\Controllers\HomeController::class, 'activity'])->name('activity');

        //reports
        Route::get('reports',[ReportController::class, 'index'])->name('reports.index');
        Route::get('/edit_report/{id}', [ReportController::class, 'edit'])->name('report.edit');
        Route::PUT('/update_report/{id}', [ReportController::class, 'update'])->name('report.update');
        Route::delete('/delete_report/{id}', [ReportController::class, 'delete'])->name('report.delete');
        Route::get('reports/export/', [ReportController::class, 'export'])->name('report.export');
        Route::post('reports/export/search', [ReportController::class, 'exportSearch'])->name('report.export.search');
        Route::get('reports/search', [ReportController::class, 'search'])->name('reports.search');
        Route::post('search/profit', [ReportController::class, 'searchProfit'])->name('search.profit');

        //dollar
        Route::PUT('dollar/update/{id}', [DollarAmountController::class,'update'])->name('dollar.update');
        Route::PUT('dollar/update/search/{id}', [DollarAmountController::class,'updateSearch'])->name('dollar.update.search');
        Route::post('profit', [DollarAmountController::class, 'profit'])->name('profit');

        //files
        Route::get('files',[FileController::class, 'index'])->name('files.index');
        Route::get('/edit_file/{id}', [FileController::class, 'edit'])->name('file.edit');
        Route::PUT('/update_file/{id}', [FileController::class, 'update'])->name('file.update');
        Route::delete('/delete_file/{id}', [FileController::class, 'delete'])->name('file.delete');
        Route::get('files/export/', [FileController::class, 'export'])->name('file.export');
        Route::post('files/export/search', [FileController::class, 'exportSearch'])->name('files.export.search');
        Route::get('files/search', [FileController::class, 'search'])->name('files.search');

        //FinancialFund
        Route::get('funds',[FinancialFundController::class, 'index'])->name('funds.index');
        Route::get('/create_fund', [FinancialFundController::class, 'create'])->name('create-fund');
        Route::get('/edit_fund/{id}', [FinancialFundController::class, 'edit'])->name('edit-fund');
        Route::PUT('/update_fund/{id}', [FinancialFundController::class, 'update'])->name('update-fund');
        Route::post('/store_fund', [FinancialFundController::class, 'store'])->name('store-fund');
        Route::delete('/delete_fund/{id}', [FinancialFundController::class, 'delete'])->name('delete-fund');
        Route::get('funds/search', [FinancialFundController::class, 'search'])->name('funds.search');
        Route::get('funds/export/', [FinancialFundController::class, 'export'])->name('funds.export');
        Route::post('funds/export/search', [FinancialFundController::class, 'exportSearch'])->name('funds.export.search');

        //LoanFund
        Route::get('loan_funds',[LoanFundController::class, 'index'])->name('loan_funds.index');
        Route::get('/create_loan_fund', [LoanFundController::class, 'create'])->name('create-loan_fund');
        Route::get('/edit_loan_fund/{id}', [LoanFundController::class, 'edit'])->name('edit-loan_fund');
        Route::PUT('/update_loan_fund/{id}', [LoanFundController::class, 'update'])->name('update-loan_fund');
        Route::post('/store_loan_fund', [LoanFundController::class, 'store'])->name('store-loan_fund');
        Route::delete('/delete_loan_fund/{id}', [LoanFundController::class, 'delete'])->name('delete-loan_fund');
        Route::get('loan_funds/search', [LoanFundController::class, 'search'])->name('loan_funds.search');
        Route::get('loan_funds/export/', [LoanFundController::class, 'export'])->name('loan_funds.export');
        Route::post('loan_funds/export/search', [LoanFundController::class, 'exportSearch'])->name('loan_funds.export.search');

        //expenditure
        Route::get('expenditures',[ExpenditureController::class, 'index'])->name('expenditures.index');
        Route::get('/create_expenditure', [ExpenditureController::class, 'create'])->name('create-expenditure');
        Route::get('/edit_expenditure/{id}', [ExpenditureController::class, 'edit'])->name('edit-expenditure');
        Route::PUT('/update_expenditure/{id}', [ExpenditureController::class, 'update'])->name('update-expenditure');
        Route::post('/store_expenditure', [ExpenditureController::class, 'store'])->name('store-expenditure');
        Route::delete('/delete_expenditure/{id}', [ExpenditureController::class, 'delete'])->name('delete-expenditure');
        Route::get('expenditures/search', [ExpenditureController::class, 'search'])->name('expenditures.search');
        Route::get('expenditures/export/', [ExpenditureController::class, 'export'])->name('expenditures.export');
        Route::post('expenditures/export/search', [ExpenditureController::class, 'exportSearch'])->name('expenditures.export.search');

        //user
        Route::get('/create_user', [App\Http\Controllers\HomeController::class, 'create'])->name('create-user');
        Route::post('/store_user', [App\Http\Controllers\HomeController::class, 'store'])->name('store-user');
        Route::get('/edit_user/{id}', [App\Http\Controllers\HomeController::class, 'edit'])->name('edit-user');
        Route::PUT('/update_user/{id}', [App\Http\Controllers\HomeController::class, 'update'])->name('update-user');
        Route::delete('/delete_user/{id}', [App\Http\Controllers\HomeController::class, 'delete'])->name('delete-user');

    });
    Route::group([
        'prefix'=>'user',
        'as'=>'user.',
    ],function (){
        //reports
        Route::get('reports',[\App\Http\Controllers\user\ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/create_report',[\App\Http\Controllers\user\ReportController::class, 'create'])->name('report.create');
        Route::post('reports/store_report',[\App\Http\Controllers\user\ReportController::class, 'store'])->name('report.store');
        Route::get('reports/edit_report/{id}', [\App\Http\Controllers\user\ReportController::class, 'edit'])->name('report.edit');
        Route::PUT('reports/update_report/{id}', [\App\Http\Controllers\user\ReportController::class, 'update'])->name('report.update');
        Route::delete('reports/delete_report/{id}', [\App\Http\Controllers\user\ReportController::class, 'delete'])->name('report.delete');


        //files
        Route::get('files',[\App\Http\Controllers\user\FileController::class, 'index'])->name('files.index');
        Route::get('files/create_file',[\App\Http\Controllers\user\FileController::class, 'create'])->name('file.create');
        Route::post('files/store_file',[\App\Http\Controllers\user\FileController::class, 'store'])->name('file.store');
        Route::get('files/edit_file/{id}', [\App\Http\Controllers\user\FileController::class, 'edit'])->name('file.edit');
        Route::PUT('files/update_file/{id}', [\App\Http\Controllers\user\FileController::class, 'update'])->name('file.update');
        Route::delete('files/delete_file/{id}', [\App\Http\Controllers\user\FileController::class, 'delete'])->name('file.delete');

    });
});

