<?php

namespace App\Models;

use App\Models\TransactionDetails;
use App\Models\Code;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function transaction_details(): HasMany
    {
        return $this->hasMany(TransactionDetails::class, 'transaction_id', 'id');
    }
}
