<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FormController;

use Inertia\Inertia;

Route::inertia('/import', 'Import');

Route::get('/receipt', function () {
    return view('Pdf.receipt');
});

Route::inertia('/login', 'Auth/Login');

Route::controller(FormController::class)->group(function () {
    Route::get('/', 'Index');

    Route::post('/submit', 'Submit');

    Route::post('/submit-import-product', 'SubmitImportProduct');

    Route::post('/submit-import-code', 'SubmitImportCode');

    Route::post('/submit-import-customer', 'SubmitImportCustomer');
});



