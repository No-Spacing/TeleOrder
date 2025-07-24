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
use App\Models\Transaction;
use App\Models\TransactionDetails;

use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $transaction = Transaction::create([
            'transaction_code' => 1,
            'code_id' => $request->code,
            'deliveredBy' => $request->deliveredBy,
            'deliveredTo' => $request->deliveredTo,
            'paymentTerms' => $request->paymentTerms,
            'specialInstruction' => $request->specialInstruction,
        ]);

        $items = $request->input('inputs');
        foreach($items as $item)
        {
            TransactionDetails::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'net_amount' => $item['net_amount'],
            ]);
        }
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

