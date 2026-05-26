<?php

// app/Models/InstructorStripeAccount.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructorStripeAccount extends Model
{
    protected $fillable = [
        'user_id',
        'stripe_account_id',
        'status',
        'payouts_enabled',
        'charges_enabled',
    ];

    protected $casts = [
        'payouts_enabled' => 'boolean',
        'charges_enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->payouts_enabled && $this->status === 'active';
    }
}
