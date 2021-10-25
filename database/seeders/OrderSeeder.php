<?php

namespace Database\Seeders;

use App\Helper\Import\Csv;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = env('ORDERS_DATA_PATH');
        $orders = Csv::import($file);

        foreach ($orders as $order) {
            Order::factory()->create([
                'id' => $order['id'],
                'product_id' => $order['product_id'],
                'inventory_id' => $order['inventory_id'],
                'street_address' => $order['street_address'],
                'apartment' => $order['apartment'],
                'city' => $order['city'],
                'state' => $order['state'],
                'country_code' => $order['country_code'],
                'zip' => $order['zip'],
                'phone_number' => $order['phone_number'],
                'email' => $order['email'],
                'name' => $order['name'],
                'order_status' => strtolower($order['order_status']),
                'payment_ref' => $order['payment_ref'],
                'transaction_id' => $order['transaction_id'],
                'payment_amount_cents' => $order['payment_amount_cents'] ?: 0,
                'ship_charged_cents' => $order['ship_charged_cents'] ?: 0,
                'ship_cost_cents' => $order['ship_cost_cents'] ?: 0,
                'subtotal_cents' => $order['subtotal_cents'] ?: 0,
                'total_cents' => $order['total_cents'] ?: 0,
                'shipper_name' => $order['shipper_name'],
                'payment_date' => Date::createFromTimeString($order['payment_date']),
                'shipped_date' => Date::createFromTimeString($order['shipped_date']),
                'tracking_number' => $order['tracking_number'],
                'tax_total_cents' => $order['tax_total_cents'],
                'created_at' => Date::createFromTimeString($order['created_at']),
                'updated_at' => Date::createFromTimeString($order['updated_at']),
            ]);
        }
    }
}
