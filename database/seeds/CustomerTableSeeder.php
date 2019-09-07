<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('customers')->insert([
          'customer_name' => 'Walk In Customer',
          'phone_number' => '0',
          'address' => '',
          'soft_delete' => '1'
      ]);
    }
}
