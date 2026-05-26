<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public const COUPON_TYPE = [
        'fixed' => 'Fixed',
        'percentage' => 'Percentage',
    ];

    public const COUPON_ACTIVE = [
        1 => 'Publish',
        0 => 'Pending',
    ];

    protected $fillable = [
        'code',
        'type',
        'value',
        'max_discount',
        'usage_limit',
        'used_count',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'max_discount' => 'decimal:2',
    ];
}
