<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory;
    protected $fillable = ['user_id',  'shipping_address', 'customer_phone', 'total_price', 'status', 'discount_id', 'status_payment', 'payment_method','id'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
