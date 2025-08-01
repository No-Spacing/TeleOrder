<?php

namespace App\Models;

use App\Models\TransactionDetails;
use App\Models\Code;
use App\Models\User;
use App\Models\Rejected;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


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
        'encoder_id',
        'approver_id',
        'status'
    ];

    public function code(): HasOne
    {
        return $this->hasOne(Code::class, 'id', 'code_id');
    }

    public function transaction_details(): HasMany
    {
        return $this->hasMany(TransactionDetails::class, 'transaction_id', 'id');
    }

    public function encoder(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'encoder_id'); 
    }

    public function approver(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'approver_id'); 
    }

    public function rejected(): HasOne
    {
        return $this->hasOne(Rejected::class, 'transaction_id', 'id');
    }
}
