<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FormController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecordController;

use App\Models\User;

use Inertia\Inertia;

Route::inertia('/import', 'Import');

Route::get('/receipt', function () {
    return view('Pdf.receipt');
});

Route::middleware(['user-auth'])->group(function () {
    Route::inertia('/', 'Auth/Login');

    Route::controller(RecordController::class)->group(function () {
        Route::get('/records', 'Records')->can('approver', User::class);

        Route::post('/view-to', 'ViewTO')->can('approver', User::class);

        Route::post('/submit-approve', 'SubmitApprove')->can('approver', User::class);

        Route::post('/submit-decline', 'SubmitDecline')->can('approver', User::class);
    });

    Route::controller(FormController::class)->group(function () {
        Route::get('/form', 'Form')->can('sales', User::class);

        Route::post('/submit', 'Submit')->can('sales', User::class);

        Route::post('/submit-import-product', 'SubmitImportProduct');

        Route::post('/submit-import-code', 'SubmitImportCode');

        Route::post('/submit-import-customer', 'SubmitImportCustomer');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'User')->can('admin', User::class);

        Route::post('/submit-user', 'SubmitUser');

        Route::post('/submit-update', 'SubmitUpdate');

        Route::get('/logout', 'Logout');
    });
});


Route::post('/login', [UserController::class, 'Login']);






