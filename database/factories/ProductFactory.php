<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->sentence(5),
            'description' => $this->faker->paragraph,
            'style' => $this->faker->sentence(3),
            'brand' => $this->faker->company,
            'url' => $this->faker->url,
            'product_type' => 'clothing',
            'shipping_price' => $this->faker->numberBetween(100, 10000),
            'note' => $this->faker->sentence(8),
            'user_id' => $this->faker->randomNumber(2,true)
        ];
    }
}
