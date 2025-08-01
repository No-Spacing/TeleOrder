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

use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function Form(Request $request)
    {
        $codes = Code::with('customers')
        ->where('code', 'LIKE', '%' . $request->search . '%')
        ->limit(5)
        ->get();

        $products = Product::where('code', 'LIKE', '%' . $request->search . '%')
        ->limit(5)
        ->get();

        return inertia('Sales/Form')->with([
            'codes' => $codes,
            'products' => $products
        ]);
    }

    public function Submit(Request $request)
    {
        $deliveredBy = $request->otherDelivery ? $request->otherDelivery : $request->deliveredBy;

        $lastTransaction = Transaction::orderBy('teleorder_no', 'desc')->first();

        $lastNumber = $lastTransaction ? (int) $lastTransaction->teleorder_no : 0;
        $newTeleorderNo = str_pad($lastNumber + 1, 6, "0", STR_PAD_LEFT);

        $transaction = Transaction::create([
            'teleorder_date' => date('Ymd'),
            'teleorder_no' => $newTeleorderNo,
            'code_id' => $request->code,
            'po_no' => $request->po_no,
            'delivery_date' => \Carbon\Carbon::parse($request->delivery_date)->setTimezone('Asia/Manila')->format('Y-m-d'),
            'order_date' => \Carbon\Carbon::parse($request->order_date)->setTimezone('Asia/Manila')->format('Y-m-d'),
            'deliveredBy' => $deliveredBy,
            'deliveredTo' => $request->deliveredTo,
            'paymentTerms' => $request->paymentTerms,
            'specialInstruction' => $request->specialInstruction,
            'status' => 'Pending'
        ]);

        $items = $request->input('inputs');
        foreach($items as $item)
        {
            $transactionDetails = TransactionDetails::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'net_amount' => $item['net_amount'],
            ]);
        }

        $customerDetails = Code::with('customer')->where('id', $request->code)->first();
        $transactionDetails = Transaction::with('transaction_details.product')->where('id', $transaction->id)->first();

        $totalNetAmount = $transactionDetails->transaction_details->sum('net_amount');

        return redirect('/form')->with(['message' => 'Success']);

        // $pdf = Pdf::loadView('Pdf.receipt', [
        //     'customer' => $customerDetails,
        //     'transaction' => $transactionDetails,
        //     'totalNetAmount' => $totalNetAmount,
        // ]);

        // return $pdf->setPaper('a4', 'portrait')->download('invoice.pdf');

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

