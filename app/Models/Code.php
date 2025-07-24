<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Customer;

class Code extends Model
{
    protected $fillable = [
        'code'
    ];

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'code_id', 'id');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'code_id', 'id');
    }
}
