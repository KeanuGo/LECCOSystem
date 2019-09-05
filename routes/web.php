<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('profile', 'UsersController@profile');
Route::post('profile', 'UsersController@update_avatar');

Route::get('/users', 'UsersController@index')->name('users.index')->middleware('auth');
Route::get('/users/view_rights/{id}', 'UsersController@view_rights')->name('users.view_rights')->middleware('auth');
Route::post('/users/update_rights/{id}', 'UsersController@update_rights')->name('users.update_rights')->middleware('auth');
Route::get('/users/delete/{id}', 'UsersController@delete')->name('users.delete')->middleware('auth');


Route::get('/members/index', 'MembersController@index')->name('members.index')->middleware('auth');
Route::get('/members/view/{id}', 'MembersController@view')->name('members.view')->middleware('auth');
Route::get('/members/create', 'MembersController@create')->name('members.create')->middleware('auth');
Route::post('/members/store', 'MembersController@store')->name('members.store')->middleware('auth');
Route::get('/members/edit/{id}', 'MembersController@edit')->name('members.edit')->middleware('auth');
Route::post('/members/update/{id}', 'MembersController@update')->name('members.update')->middleware('auth');
Route::get('/members/delete/{id}', 'MembersController@delete')->name('members.delete')->middleware('auth');

Route::get('/loans/index', 'LoansController@index')->name('loans.index')->middleware('auth');
Route::get('loans/aging_loans', 'LoansController@view_aging_loans')->name('loans.view_aging_loans')->middleware('auth');
Route::get('/loans/view/{id}', 'LoansController@view')->name('loans.view')->middleware('auth');
Route::get('/loans/create', 'LoansController@create')->name('loans.create')->middleware('auth');
Route::get('/loans/delete/{id}', 'LoansController@delete')->name('loans.delete')->middleware('auth');
Route::post('/loans/store', 'LoansController@store')->name('loans.store')->middleware('auth');
Route::get('/loans/lpds', 'LoansController@lpds')->name('loans.lpds')->middleware('auth');
Route::post('/loans/update/{id}', 'LoansController@update')->name('loans.update')->middleware('auth');
Route::get('/loans/viewschedule/{id}/{id2}', 'LoansController@viewschedule')->name('loans.viewschedule')->middleware('auth');

Route::get('loan_types/index', 'LoanTypesController@index')->name('loan_types.index')->middleware('auth');
Route::get('loan_types/create', 'LoanTypesController@create')->name('loan_types.create')->middleware('auth');
Route::post('loan_types/store', 'LoanTypesController@store')->name('loan_types.store')->middleware('auth');
Route::get('loan_types/view/{id}', 'LoanTypesController@view')->name('loan_types.view')->middleware('auth');
Route::get('loan_types/edit/{id}', 'LoanTypesController@edit')->name('loan_types.edit')->middleware('auth');
Route::post('loan_types/update/{id}', 'LoanTypesController@update')->name('loan_types.update')->middleware('auth');
Route::get('loan_types/delete/{id}', 'LoanTypesController@delete')->name('loan_types.delete')->middleware('auth');

Route::get('payment_schedule/create/', 'PaymentSchedulesController@create')->name('payment_schedule.create')->middleware('auth');
Route::get('payment_schedule/store/', 'PaymentSchedulesController@store')->name('payment_schedule.store')->middleware('auth');
Route::post('payment_schedule/update/', 'PaymentSchedulesController@update')->name('payment_schedule.update')->middleware('auth');
Route::post('payment_schedule/undo/', 'PaymentSchedulesController@undo')->name('payment_schedule.undo')->middleware('auth');

Route::get('/shares/index', 'SharesController@index')->name('shares.index')->middleware('auth');
Route::get('shares/create', 'SharesController@create')->name('shares.create')->middleware('auth');
Route::post('shares/store', 'SharesController@store')->name('shares.store')->middleware('auth');
Route::get('shares/view/{id}', 'SharesController@view')->name('shares.view')->middleware('auth');

Route::get('/coa/index', 'ChartofAccountsController@index')->name('coa.index')->middleware('auth');
Route::get('coa/create', 'ChartofAccountsController@create')->name('coa.create')->middleware('auth');
Route::post('coa/store', 'ChartofAccountsController@store')->name('coa.store')->middleware('auth');
Route::get('coa/edit/{id}', 'ChartofAccountsController@edit')->name('coa.edit')->middleware('auth');
Route::post('coa/update/{id}', 'ChartofAccountsController@update')->name('coa.update')->middleware('auth');
Route::get('coa/delete/{id}', 'ChartofAccountsController@delete')->name('coa.delete')->middleware('auth');

Route::get('/signatories/index', 'SignatoriesController@index')->name('signatories.index')->middleware('auth');
Route::get('signatories/create', 'SignatoriesController@create')->name('signatories.create')->middleware('auth');
Route::post('signatories/store', 'SignatoriesController@store')->name('signatories.store')->middleware('auth');
Route::get('signatories/edit/{id}', 'SignatoriesController@edit')->name('signatories.edit')->middleware('auth');
Route::post('signatories/update/{id}', 'SignatoriesController@update')->name('signatories.update')->middleware('auth');
Route::get('signatories/delete/{id}', 'SignatoriesController@delete')->name('signatories.delete')->middleware('auth');

Route::get('/check_voucher/index', 'CheckVoucherController@index')->name('check_voucher.index')->middleware('auth');
Route::get('check_voucher/create', 'CheckVoucherController@create')->name('check_voucher.create')->middleware('auth');
Route::post('check_voucher/store', 'CheckVoucherController@store')->name('check_voucher.store')->middleware('auth');
Route::get('check_voucher/view/{id}', 'CheckVoucherController@view')->name('check_voucher.view')->middleware('auth');
Route::get('check_voucher/edit/{id}', 'CheckVoucherController@edit')->name('check_voucher.edit')->middleware('auth');
Route::post('check_voucher/update/{id}', 'CheckVoucherController@update')->name('check_voucher.update')->middleware('auth');
Route::get('check_voucher/delete/{id}', 'CheckVoucherController@delete')->name('check_voucher.delete')->middleware('auth');
Route::get('check_voucher/remove_attachment/{id}', 'CheckVoucherController@remove_attachment')->name('check_voucher.remove_attachment')->middleware('auth');

Route::get('check_voucher/general_summary_of_accounts', 'CheckVoucherController@general_summary_of_accounts')->name('check_voucher.general_summary_of_accounts')->middleware('auth');
Route::get('check_voucher/sub_summary_of_accounts', 'CheckVoucherController@sub_summary_of_accounts')->name('check_voucher.sub_summary_of_accounts')->middleware('auth');
Route::get('check_voucher/sub_sub_summary_of_accounts', 'CheckVoucherController@sub_sub_summary_of_accounts')->name('check_voucher.sub_sub_summary_of_accounts')->middleware('auth');