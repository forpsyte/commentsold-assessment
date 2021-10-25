<?php

namespace Database\Factories;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inventory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => $this->faker->randomNumber(4),
            'quantity' => $this->faker->randomNumber(3),
            'color' => $this->faker->colorName,
            'size' => $this->faker->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XXL']),
            'weight' => $this->faker->randomNumber(1, true),
            'price_cents' => $this->faker->randomNumber(4, true),
            'sale_price_cents' => $this->faker->randomNumber(4, true),
            'cost_cents' => $this->faker->randomNumber(4, true),
            'sku' => $this->faker->unique()->regexify('[A-Z]{6}'),
            'length' => $this->faker->randomNumber(1, true),
            'width' => $this->faker->randomNumber(1, true),
            'height' => $this->faker->randomNumber(1, true),
            'note' => $this->faker->sentence
        ];
    }
}
