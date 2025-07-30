<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Transaction;


class RecordController extends Controller
{
    public function Index(Request $request)
    {
        $records = Transaction::all();

        return inertia('Records', [
            'records' => $records,
        ]);
    }
}
