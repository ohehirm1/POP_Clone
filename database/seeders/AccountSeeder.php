<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Account::insert([
            ['budget' => '01', 'code' => '311'],
            ['budget' => '04', 'code' => '312'],
            ['budget' => '03', 'code' => '313'],
            ['budget' => '02', 'code' => '314'],
            ['budget' => '15', 'code' => '315'],
            ['budget' => '07', 'code' => '316'],
            ['budget' => '08', 'code' => '317'],
            ['budget' => '09', 'code' => '318'],
            ['budget' => '05', 'code' => '319'],
            ['budget' => '11', 'code' => '320'],
            ['budget' => '12', 'code' => '321'],
            ['budget' => '14', 'code' => '322'],
        ]);
    }
}
