<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Color;
use App\Models\ColorSize;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user =
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role_as' => '2',

            ];

        $categorys = [
            [
                'category_name' => 'men',
                'category_slug' => 'men',
                'category_status' => '0',
            ],
            [
                'category_name' => 'women',
                'category_slug' => 'women',
                'category_status' => '0',
            ],

        ];
        $subcategorys = [
            [
                'category_id' => 1,
                'subcategory_name' => 'basas',
                'subcategory_slug' => 'basas',
            ],
            [
                'category_id' => 1,
                'subcategory_name' => 'vintas',
                'subcategory_slug' => 'vintas',
            ],
            [
                'category_id' => 1,
                'subcategory_name' => 'urbas',
                'subcategory_slug' => 'urbas',
            ],
            [
                'category_id' => 1,
                'subcategory_name' => 'pattas',
                'subcategory_slug' => 'pattas',
            ],
            [
                'category_id' => 2,
                'subcategory_name' => 'basas',
                'subcategory_slug' => 'basas',
            ],
            [
                'category_id' => 2,
                'subcategory_name' => 'vintas',
                'subcategory_slug' => 'vintas',
            ],
            [
                'category_id' => 2,
                'subcategory_name' => 'urbas',
                'subcategory_slug' => 'urbas',
            ],
            [
                'category_id' => 2,
                'subcategory_name' => 'pattas',
                'subcategory_slug' => 'pattas',
            ],


        ];
        $colors = [
            ['color_name' => 'Red', 'color_code' => '#FF0000'],
            ['color_name' => 'Green', 'color_code' => '#008000'],
            ['color_name' => 'Blue', 'color_code' => '#0000FF'],
            ['color_name' => 'Yellow', 'color_code' => '#FFFF00'],
            ['color_name' => 'Orange', 'color_code' => '#FFA500'],
            ['color_name' => 'Purple', 'color_code' => '#800080']
        ];

        foreach ($colors as $colorData) {
            $color = new Color($colorData);
            $color->save();
        }
        $sizes = [
            ['size_name' => 'XS'],
            ['size_name' => 'S'],
            ['size_name' => 'M'],
            ['size_name' => 'L'],
            ['size_name' => 'XL'],
            ['size_name' => 'XXL']
        ];

        foreach ($sizes as $sizeData) {
            $size = new Size($sizeData);
            $size->save();
        }
        User::create($user);
        foreach ($categorys as $category) {
            Category::create($category);
        }
        foreach ($subcategorys as $i => $subcategory) {
            Subcategory::create($subcategory);
            $category = Category::findOrFail($subcategory['category_id']);
            $category->increment('subcategory_count');
        }

        $products = [
            [
                'product_name' => 'Workaday',
                'product_description' => 'Description for product 1',
                'product_type' => 'low top',
                'product_material' => 'canvas',
                'product_price' => 10,
                'product_slug' => 'workaday',
                'subcategory_id' => 1,
                'colors' => [1, 2],
                'sizes' => [1, 2],
                'quantities' => [10, 20]
            ],
            [
                'product_name' => 'Jazico',
                'product_description' => 'Description for product 2',
                'product_type' => 'high top',
                'product_material' => 'canvas',
                'product_price' => 20,
                'product_slug' => 'jazico',
                'subcategory_id' => 2,
                'colors' => [3, 4],
                'sizes' => [3, 4],
                'quantities' => [5, 10]
            ],
            [
                'product_name' => 'Corluray Mix',
                'product_description' => 'Description for product 1',
                'product_type' => 'low top',
                'product_material' => 'canvas',
                'product_price' => 10,
                'product_slug' => 'corluray-mix',
                'subcategory_id' => 3,
                'colors' => [1, 2],
                'sizes' => [1, 2],
                'quantities' => [10, 20]
            ],
            [
                'product_name' => 'Living Journey',
                'product_description' => 'Description for product 2',
                'product_type' => 'high top',
                'product_material' => 'canvas',
                'product_price' => 20,
                'product_slug' => 'living-journey',
                'subcategory_id' => 4,
                'colors' => [3, 4],
                'sizes' => [3, 4],
                'quantities' => [5, 10]
            ],
            [
                'product_name' => 'Workaday',
                'product_description' => 'Description for product 1',
                'product_type' => 'low top',
                'product_material' => 'canvas',
                'product_price' => 10,
                'product_slug' => 'workaday',
                'subcategory_id' => 5,
                'colors' => [1, 2],
                'sizes' => [1, 2],
                'quantities' => [10, 20]
            ],
            [
                'product_name' => 'Jazico',
                'product_description' => 'Description for product 2',
                'product_type' => 'high top',
                'product_material' => 'canvas',
                'product_price' => 20,
                'product_slug' => 'jazico',
                'subcategory_id' => 6,
                'colors' => [3, 4],
                'sizes' => [3, 4],
                'quantities' => [5, 10]
            ],
            [
                'product_name' => 'Corluray Mix',
                'product_description' => 'Description for product 1',
                'product_type' => 'low top',
                'product_material' => 'canvas',
                'product_price' => 10,
                'product_slug' => 'corluray-mix',
                'subcategory_id' => 7,
                'colors' => [1, 2],
                'sizes' => [1, 2],
                'quantities' => [10, 20]
            ],
            [
                'product_name' => 'Living Journey',
                'product_description' => 'Description for product 2',
                'product_type' => 'high top',
                'product_material' => 'canvas',
                'product_price' => 20,
                'product_slug' => 'living-journey',
                'subcategory_id' => 8,
                'colors' => [3, 4],
                'sizes' => [3, 4],
                'quantities' => [5, 10]
            ],

        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->product_name=$productData['product_name'];
            $product->product_description=$productData['product_description'];
            $product->product_type=$productData['product_type'];
            $product->product_material=$productData['product_material'];
            $product->product_price=$productData['product_price'];
            $product->product_slug=$productData['product_slug'];
            $product->subcategory_id=$productData['subcategory_id'];
            $subcategory = Subcategory::find($productData['subcategory_id']);
            $product->category_id =$subcategory->category_id;
            $product->save();
            $subcategory = SubCategory::find($productData['subcategory_id']);
            $subcategory->increment('product_count');
            $colors = $productData['colors'];
            $sizes = $productData['sizes'];
            $quantities = $productData['quantities'];

            foreach ($colors as $key => $color) {
                $size = $sizes[$key];
                $quantity = $quantities[$key];

                $colorSize = new ColorSize([
                    'product_id' => $product->id,
                    'color_id' => $color,
                    'size_id' => $size,
                    'quantity' => $quantity
                ]);

                $colorSize->save();
            }
        }
    }


}
