<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Transaction;
use App\Models\Code;
use App\Models\Rejected;

use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    public function Records(Request $request)
    {
        $records = Transaction::with('code.customer')
        ->whereRaw("CONCAT(teleorder_date, teleorder_no) LIKE ?", ["%{$request->search}%"])
        ->orWhereHas('Code', function ($query) use ($request) {
            $query->where('code', 'LIKE', "%{$request->search}%"); // Replace 'code_no' with your actual column name
        })
        ->paginate(10);

        return inertia('Approver/Records', [
            'records' => $records,
        ]);
    }

    public function ViewTO(Request $request)
    {
        $customerDetails = Code::with('customer')->where('id', $request->code_id)->first();
        $transactionDetails = Transaction::with('transaction_details.product', 'approver', 'rejected')->where('id', $request->id)->first();
        $totalNetAmount = $transactionDetails->transaction_details->sum('net_amount');

        $pdf = Pdf::loadView('Pdf.receipt', [
            'customer' => $customerDetails,
            'transaction' => $transactionDetails,
            'totalNetAmount' => $totalNetAmount,
        ]);
        
        return $pdf->setPaper('a4', 'portrait')->download('invoice.pdf');

        // return view('Pdf.receipt')->with([
        //     'customer' => $customerDetails,
        //     'transaction' => $transactionDetails,
        //     'totalNetAmount' => $totalNetAmount,
        // ]);
    }

    public function SubmitApprove(Request $request)
    {
        Transaction::where('id', $request->id)
        ->update([
            'status' => 'Approved',
            'approver_id' => Auth::id(),
        ]);

        return redirect('/records')->with(['message' => 'TeleOrder has been approved']);
    }
    
    public function SubmitDecline(Request $request)
    {  
        // Transaction::where('id', $request->id)
        // ->update(['status' => 'Declined']);

        // Rejected::create([
        //     'type' => $request->type,
        //     'credit_limit' => $request->credit_limit,
        //     'cl_balance' => $request->cl_balance,
        //     'order_taken_by' => $request->order_taken_by,
        //     'transaction_id' => $request->id,
        // ]);

        return redirect('/records')->with(['message' => 'TeleOrder has been declined']);
    }
}
