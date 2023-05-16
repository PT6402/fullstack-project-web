<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'product_description',
        'product_price',
        'product_slug',
        'category_id',
        'subcategory_id',
        'product_status'

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }


    public function colors()
    {
        return $this->hasMany(Color::class);
    }
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function getColumnNames()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
    public function colorSizes()
    {
        return $this->belongsToMany(ColorSize::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
