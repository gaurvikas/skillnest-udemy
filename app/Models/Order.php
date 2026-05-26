<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_FAILED = 'failed';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUS_REFUNDED = 'refunded';

    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',
        'discount',
        'coupon_code',
        'total',
        'country',
        'state',
        'status',
        'paid_at',
        'payment_intent_id',
        'stripe_session_id',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            $order->order_number = self::generateUniqueOrderNumber();
        });
    }

    private static function generateUniqueOrderNumber()
    {
        $date = now()->format('Ymd');
        $lastOrder = self::whereDate('created_at', now())
            ->latest()
            ->first();

        $sequence = $lastOrder
            ? ((int) substr($lastOrder->order_number, -4)) + 1
            : 1;

        return 'ORD-'.$date.'-'.str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Order.php mein add karo

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
