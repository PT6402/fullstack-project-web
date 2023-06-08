<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Color;
use App\Models\ColorSize;
use App\Models\Product;
use App\Models\ProductImage;
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
            ['color_name' => 'red', 'color_code' => '#FF0000'],
            ['color_name' => 'green', 'color_code' => '#008000'],
            ['color_name' => 'blue', 'color_code' => '#0000FF'],
            ['color_name' => 'yellow', 'color_code' => '#FFFF00'],
            ['color_name' => 'orange', 'color_code' => '#FFA500'],
            ['color_name' => 'purple', 'color_code' => '#800080']
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
                'product_slug' => 'workaday_1',
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
                'product_slug' => 'jazico_2',
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
                'product_slug' => 'corluray-mix_3',
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
                'product_slug' => 'living-journey_4',
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
                'product_slug' => 'workaday_5',
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
                'product_slug' => 'jazico_6',
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
                'product_slug' => 'corluray-mix_7',
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
                'product_slug' => 'living-journey_8',
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

        foreach ($products as $index =>$productData) {
            $product = Product::where("id",$index+1)->first();

            if ($product) {
                $colors = $productData['colors'];

                foreach ($colors as $colorId) {
                    // $imageName = $product->product_name.'.jpg';
                    // Đường dẫn ảnh tùy thuộc vào color_id và product_id
                    $imagePath = '/images/'.$product->product_name.'_'.$colorId.'.jpg';

                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->color_id = $colorId;
                    $productImage->url = $imagePath;
                    $productImage->save();
                }
            }
        }
    }







}
