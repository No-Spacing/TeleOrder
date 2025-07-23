<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Customer;

class Code extends Model
{
    protected $fillable = [
        'code'
    ];

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'code_id', 'id');
    }
}
