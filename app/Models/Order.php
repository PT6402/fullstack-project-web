<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory;
    protected $fillable = ['user_id', 'name_user', 'address_label', 'phone','standard','express', 'total_price', 'status', 'discount_name','discount_value', 'status_payment', 'payment_method','id','created_at'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
