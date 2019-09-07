<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('settings')->insert([
          'company_name' => 'Your Company Name',
          'phone_number' => 'Company Number',
          'address' => "Company Address",
          'currency' => 'BDT',
          'default_vat' => 15,
          'logo' => 'defaultcompanylogo.png',
          'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
          'time_zone' => 'Asia/Dhaka',
          'delivery_charge' => 60,
      ]);
    }
}
