<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BillController;

Route::get('/redirect', [HomeController::class, 'redirect']);

Route::get('/', [HomeController::class, 'index']);

Route::get('/payment_page', [HomeController::class, 'payment_page']);

Route::get('/check_bill_page', [HomeController::class, 'check_bill_page']);





// Route to show the payment form
Route::get('/pay', [PaymentController::class, 'showPaymentForm'])->name('payment.form');

// Route to process the payment
Route::post('/bkash_payment', [PaymentController::class, 'processPayment'])->name('bkash.payment');

// Routes for success and failure pages
Route::get('/payment/success', [PaymentController::class, 'successPage'])->name('payment.success');
Route::get('/payment/failed', [PaymentController::class, 'failedPage'])->name('payment.failed');





Route::get('/add_package_page', [AdminController::class, 'add_package_page']);

Route::get('/view_package_page', [AdminController::class, 'view_package_page']);

Route::get('/add_user_page', [AdminController::class, 'add_user_page']);

Route::get('/view_users_page', [AdminController::class, 'view_users_page']);

Route::get('/bill_history_page', [AdminController::class, 'bill_history_page']);




Route::post('/add_package', [PackageController::class, 'store']);





Route::get('/get_packages', [PackageController::class, 'getPackages']);
Route::get('/get_package/{id}', [PackageController::class, 'getPackage']);
Route::put('/update_package/{id}', [PackageController::class, 'updatePackage']);
Route::delete('/delete_package/{id}', [PackageController::class, 'deletePackage']);



Route::post('/add_user', [CustomerController::class, 'store']);





Route::get('get_customers', [CustomerController::class, 'getCustomers']);
Route::get('get_customer/{id}', [CustomerController::class, 'getCustomer']);
Route::put('update_customer/{id}', [CustomerController::class, 'updateCustomer']);
Route::delete('delete_customer/{id}', [CustomerController::class, 'deleteCustomer']);







Route::get('/get_bills', [BillController::class, 'getBills'])->name('bills.get');
Route::post('/send_sms/{bill}', [BillController::class, 'sendSms'])->name('bills.send_sms');
Route::post('/change_status/{bill}', [BillController::class, 'changeStatus'])->name('bills.change_status');
Route::delete('/delete_bill/{bill}', [BillController::class, 'deleteBill'])->name('bills.delete');




Route::post('/check-bill', [PaymentController::class, 'checkBillForm'])->name('check_bill_form');




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
