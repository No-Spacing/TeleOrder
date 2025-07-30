<?php

namespace App\Models;

use App\Models\TransactionDetails;
use App\Models\Code;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = [
        'teleorder_date',
        'teleorder_no',
        'code_id',
        'po_no',
        'delivery_date',
        'order_date',
        'paymentTerms',
        'deliveredBy',
        'deliveredTo',
        'specialInstruction',
        'user_id',
        'status'
    ];

    public function transaction_details(): HasMany
    {
        return $this->hasMany(TransactionDetails::class, 'transaction_id', 'id');
    }
}
