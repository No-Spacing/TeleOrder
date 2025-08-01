<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'role',
    ];

    public const IS_APPROVER = 1;
    public const IS_ENCODER = 2;
    public const IS_SALES = 3;
    public const IS_ADMIN = 4;
}
