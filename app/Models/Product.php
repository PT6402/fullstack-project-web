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
        'product_status',
        'product_type',
        'product_material', 'id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function item()
    {
        return $this->belongsTo(Cartitem::class);
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
        return $this->belongsToMany(ColorSize::class, 'color_sizes');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    public function saleItems()
    {
        return $this->belongsToMany(SaleItem::class);
    }
    public function calculateAverageRatingForProducts()
    {
        // Lấy danh sách tất cả sản phẩm
        $products = Product::where("id", $this->id)->get();

        foreach ($products as $product) {
            // Lấy tất cả các đánh giá (ratings) của sản phẩm
            $ratings = $product->reviews;

            // Tính tổng các giá trị rating
            $totalRating = 0;
            $countRate = 0;
            foreach ($ratings as $rating) {
                $totalRating += $rating->rate;
                $countRate++;
            }

            // Tính lượt rate trung bình
            $averageRating = count($ratings) > 0 ? round($totalRating / count($ratings), 1) : 0;

            // Lưu lượt rate trung bình vào sản phẩm
            // $averageRating;

            return  ["rate" => $averageRating, "count" => $countRate++];
        }
    }
}
