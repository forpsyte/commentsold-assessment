<?php

namespace Database\Seeders;

use App\Helper\Import\Csv;
use App\Models\Inventory;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = env('INVENTORY_DATA_PATH');
        $inventories = Csv::import($file);

        foreach ($inventories as $inventory) {
            Inventory::factory()->create([
                'id' => $inventory['id'],
                'product_id' => $inventory['product_id'],
                'quantity' => $inventory['quantity'],
                'color' => $inventory['color'],
                'size' => $inventory['size'],
                'weight' => $inventory['weight'],
                'price_cents' => $inventory['price_cents'],
                'sale_price_cents' => $inventory['sale_price_cents'],
                'cost_cents' => $inventory['cost_cents'],
                'sku' => $inventory['sku'],
                'length' => $inventory['length'],
                'width' => $inventory['width'],
                'height' => $inventory['height'],
                'note' => $inventory['note'],
            ]);
        }
    }
}
