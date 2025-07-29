<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FormController;
use App\Http\Controllers\UserController;

use Inertia\Inertia;

Route::inertia('/import', 'Import');

Route::get('/receipt', function () {
    return view('Pdf.receipt');
});

Route::middleware(['user-auth'])->group(function () {
    Route::inertia('/', 'Auth/Login');

    Route::controller(FormController::class)->group(function () {
        Route::get('/form', 'Index');

        Route::post('/submit', 'Submit');

        Route::post('/submit-import-product', 'SubmitImportProduct');

        Route::post('/submit-import-code', 'SubmitImportCode');

        Route::post('/submit-import-customer', 'SubmitImportCustomer');
    });
});


Route::post('/login', [UserController::class, 'Login']);

Route::get('/logout', [UserController::class, 'Logout']);




