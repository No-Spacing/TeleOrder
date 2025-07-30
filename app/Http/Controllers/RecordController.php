<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction;

class RecordController extends Controller
{
    public function Index(Request $request)
    {
        $records = Transaction::with('code.customer')->where('')->paginate(10);

        return inertia('Records', [
            'records' => $records,
        ]);
    }

    public function ViewTo(Request $request)
    {
        $customerDetails = Code::with('customer')->where('id', $request->code)->first();
        $transactionDetails = Transaction::with('transaction_details.product')->where('id', $transaction->id)->first();

        $totalNetAmount = $transactionDetails->transaction_details->sum('net_amount');

        $pdf = Pdf::loadView('Pdf.receipt', [
            'customer' => $customerDetails,
            'transaction' => $transactionDetails,
            'totalNetAmount' => $totalNetAmount,
            'user' => Auth::user()->name,
        ]);

        return $pdf->setPaper('a4', 'portrait')->download('invoice.pdf');
    }

    public function SubmitApprove(Request $request)
    {
        Transaction::where('id', $request->id)
        ->update(['status' => 'Approved']);
    }
    
    public function SubmitDecline(Request $request)
    {  
        Transaction::where('id', $request->id)
        ->update(['status' => 'Declined']);
    }
}
