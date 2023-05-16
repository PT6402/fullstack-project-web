<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $fillable = [
        'color_name',
        'color_code',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'color_sizes');
                    // ->withPivot('size_id', 'quantity')
                    // ->withTimestamps();
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'color_size', 'color_id', 'size_id')->withPivot('quantity');
    }

}
