<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => $this->faker->randomNumber(4, true),
            'inventory_id' => $this->faker->randomNumber(4, true),
            'street_address' => $this->faker->streetAddress,
            'apartment' => $this->faker->randomNumber(3, true),
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country_code' => $this->faker->countryCode,
            'zip' => $this->faker->postcode,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'order_status' => $this->faker->randomElement(['Fulfilled', 'Shipped', 'Paid', 'Pending', 'Open']),
            'payment_ref' => $this->faker->regexify('[A-Za-z0-9]{8}'),
            'transaction_id' => $this->faker->regexify('[A-Za-z0-9]{12}'),
            'payment_amount_cents' => $this->faker->randomNumber(4),
            'ship_charged_cents' => $this->faker->randomNumber(4),
            'ship_cost_cents' => $this->faker->randomNumber(4),
            'subtotal_cents' => $this->faker->randomNumber(4),
            'total_cents' => $this->faker->randomNumber(4),
            'shipper_name' => $this->faker->randomElement(['DHL', 'USPS', 'UPS', 'FedEx']),
            'payment_date' => now(),
            'shipped_date' => now(),
            'tracking_number' => $this->faker->regexify('[A-Za-z0-9]{13}'),
            'tax_total_cents' => $this->faker->randomNumber(3, true),
        ];
    }
}
