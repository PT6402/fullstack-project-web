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
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
    // public function category()
    // {
    //     return $this->belongsTo(Category::class, 'category_id');
    // }
    // public function subcategory()
    // {
    //     return $this->belongsTo(Subcategory::class, 'subcategory_id');
    // }
}
