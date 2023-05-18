<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;
    protected $fillable = ['sale_id', 'product_id', 'discount_price'];
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
