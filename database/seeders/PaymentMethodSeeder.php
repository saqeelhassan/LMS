<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = ['Cash', 'Bank Transfer', 'Wallet Apps'];

        // Remove payment methods that are no longer in the list
        PaymentMethod::whereNotIn('name', $methods)->delete();

        foreach ($methods as $name) {
            PaymentMethod::firstOrCreate(['name' => $name]);
        }
    }
}
