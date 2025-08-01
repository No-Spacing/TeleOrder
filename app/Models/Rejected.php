<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rejected extends Model
{
    protected $fillable = [
        'type',
        'credit_limit',
        'cl_balance',
        'order_taken_by',
        'transaction_id',
    ];
}
