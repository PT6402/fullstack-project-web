<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $fillable = ['subcategory_name', 'category_id','subcategory_slug','subcategory_status','image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function getColumnNames()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($subcategory) {
            $products = $subcategory->products;

            foreach ($products as $product) {
                $product->category_id = $subcategory->category_id;
                $product->save();
            }
        });
    }
}
