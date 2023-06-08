<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'url','is_main','color_id'];
    use HasFactory;
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function color()
{
    return $this->belongsTo(Color::class, 'color_id');
}
}
