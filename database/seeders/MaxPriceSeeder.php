<?php

namespace Database\Seeders;

use App\Models\MaxPrice;
use Illuminate\Database\Seeder;

class MaxPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // MaxPrice::factory(10)->create();
        MaxPrice::insert([
            ['item' => '01_019_0120_1_1', 'price' => 50.8 * 100],
            ['item' => '01_020_0120_1_1', 'price' => 51.81 * 100],
            ['item' => '01_701_0128_1_3', 'price' => 214.41 * 100],
            ['item' => '01_721_0128_1_3', 'price' => 193.99 * 100],
            ['item' => '01_741_0128_1_3', 'price' => 193.99 * 100],
            ['item' => '12_025_0128_3_3', 'price' => 193.99 * 100],
            ['item' => '12_027_0126_3_3', 'price' => 166.99 * 100],
            ['item' => '12_027_0128_3_3', 'price' => 166.99 * 100],
            ['item' => '12_029_0126_3_3', 'price' => 59.81 * 100],
            ['item' => '15_054_0128_1_3', 'price' => 214.41 * 100],
            ['item' => '15_055_0128_1_3', 'price' => 193.99 * 100],
            ['item' => '15_056_0128_1_3', 'price' => 193.99 * 100],
            ['item' => '15_062_0128_3_3', 'price' => 193.99 * 100],
            ['item' => '15_200_0126_1_3', 'price' => 166.99 * 100],
            ['item' => '15_200_0128_1_3', 'price' => 166.99 * 100],
            ['item' => '15_222400911_0124_1_3', 'price' => 1.00 * 100],
        ]);
    }
}
