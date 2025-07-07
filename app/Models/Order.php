<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'notes',
        'status'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'id');
    }
}
