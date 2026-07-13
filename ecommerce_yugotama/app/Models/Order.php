<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'payment_method',
        'payment_status',
        'subtotal',
        'shipping_cost',
        'discount',
        'total',
        'notes',
        'proof_of_payment',
        'rejection_reason',
        'verified_at',
        'verified_by',
        'delivery_address',
        'delivery_courier',
        'delivery_tracking',
        'shipped_at',
        'delivered_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
