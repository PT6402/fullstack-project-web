<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'total_price', 'discount_id','total_amount'];
    // protected $guarded = ['id', 'created_at', 'updated_at'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
    public function totalPrice()
    {
        $total = $this->total_price;
        if ($this->discount_id) {
            $discount = Discount::find($this->discount_id);
            $this->total_price  -=  ($total * $discount->value / 100);
        }
        $this->save();
        // trừ đi giảm giá
        return $total;
    }
    public function totalPriceRemoveDiscount($totalPrice)
    {
        $total = $this->total_price;

        if ($this->discount_id) {
            $discount = Discount::find($this->discount_id);
            $this->total_price +=  ($totalPrice * $discount->value / 100);
        }
        $this->save();
        // trừ đi giảm giá
        return $total;
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
