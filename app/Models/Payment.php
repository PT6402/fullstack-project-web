<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','cart_id','status_payment','total_price','payment_method'];
    public function user()
{
    return $this->belongsTo(User::class);
}
public function orders()
{
    return $this->hasMany(Order::class);
}
public function cart()
{
    return $this->hasOne(Cart::class);
}
}
