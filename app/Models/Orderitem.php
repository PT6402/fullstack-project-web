<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    use HasFactory;
    protected $fillable = [

        'product_id',
        'color_id',
        'size_id',
        'quantity',
        'total_price',
        'order_id'
    ];
}
