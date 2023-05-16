<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $fillable = ['size_name'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'color_sizes');
        // ->withPivot('quantity')->withTimestamps();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
