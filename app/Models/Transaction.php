<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_code',
        'code_id',
        'paymentTerms',
        'deliveredBy',
        'deliveredBy',
        'deliveredTo',
        'specialInstruction',
        'user_id',
    ];
}
