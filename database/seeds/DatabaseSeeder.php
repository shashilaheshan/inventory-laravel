<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SettingTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(StoreStatusSeeder::class);
        $this->call(Expense_categoriesSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
