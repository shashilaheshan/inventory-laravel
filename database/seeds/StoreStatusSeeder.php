<?php

use Illuminate\Database\Seeder;

class StoreStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('store_status')->insert([
          'cash_in_hand' => '0',
          'store_close' =>'no'
      ]);
    }
}
