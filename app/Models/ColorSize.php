<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorSize extends Model
{
    use HasFactory;
    protected $fillable = [
        'size_id',
        'color_id',
        'product_id',
        'quantity',
    ];

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function cartItem()
{
    return $this->hasOne(CartItem::class, 'color_sizes');
}

}
