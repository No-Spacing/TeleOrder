<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;

use App\Imports\ProductImport;
use App\Imports\CodeImport;
use App\Imports\CustomerImport;

use App\Models\Code;
use App\Models\Customer;
use App\Models\Product;

use Maatwebsite\Excel\Facades\Excel;

class FormController extends Controller
{
    public function Index(Request $request)
    {
        $codes = Code::with('customers')
        ->where('code', 'LIKE', '%' . $request->search . '%')
        ->limit(5)
        ->get();

        $products = Product::where('code', 'LIKE', '%' . $request->search . '%')
        ->limit(5)
        ->get();

        return inertia('Form')->with([
            'codes' => $codes,
            'products' => $products
        ]);
    }

    public function Submit(Request $request)
    {
        // $items = $request->input('inputs');

    }

    public function SubmitImportProduct(Request $request)
    {
        Excel::import(new ProductImport, $request->file);
    }

    public function SubmitImportCode(Request $request)
    {
        Excel::import(new CodeImport, $request->file);
    }

    public function SubmitImportCustomer(Request $request)
    {
        Excel::import(new CustomerImport, $request->file);
    }
}

