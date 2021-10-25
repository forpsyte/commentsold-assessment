<?php

namespace Database\Seeders;

use App\Helper\Import\Csv;
use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = Account::create(['name' => 'CommentSold']);
        $file = env('USER_DATA_PATH');
        $users = Csv::import($file);

        foreach ($users as $user) {
            $name = explode(" ", $user['name']);
            User::factory()->create([
                'id' => $user['id'],
                'account_id' => $account->id,
                'first_name' => array_shift($name),
                'last_name' => array_shift($name),
                'email' => $user['email'],
                'password' => $user['password'],
                'owner' => $user['super_admin'],
                'shop_name' => $user['shop_name'],
                'card_brand' => $user['card_brand'],
                'card_last_four' => $user['card_last_four'],
                'trial_ends_at' => Date::createFromTimeString($user['trial_ends_at']),
                'shop_domain' => $user['shop_domain'],
                'is_enabled' => $user['is_enabled'],
                'billing_plan' => $user['billing_plan'],
                'trial_starts_at' => Date::createFromTimeString($user['trial_starts_at']),
                'updated_at' => Date::createFromTimeString($user['updated_at']),
                'created_at' => Date::createFromTimeString($user['created_at']),
            ]);
        }
    }
}
