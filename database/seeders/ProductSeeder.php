<?php

namespace Database\Seeders;

use App\Helper\Import\Csv;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = env('PRODUCT_DATA_PATH');
        $products = Csv::import($file);

        foreach ($products as $product) {
            Product::factory()->create([
                'id' => $product['id'],
                'user_id' => $product['user_id'],
                'product_name' => $product['product_name'],
                'description' => $product['description'],
                'style' => $product['style'],
                'brand' => $product['brand'],
                'url' => $product['url'],
                'created_at' => Date::createFromTimeString($product['created_at']),
                'updated_at' =>  Date::createFromTimeString($product['updated_at']),
                'product_type' => $product['product_type'],
                'shipping_price' => $product['shipping_price'],
                'note' => $product['note'],
            ]);
        }
    }
}
