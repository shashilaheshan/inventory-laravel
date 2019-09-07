<?php

use Illuminate\Database\Seeder;

class Expense_categoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('expense_categories')->insert([
          [
              'category_name' => 'Withdraw At Store Close',
              'created_at' => \Carbon\Carbon::now()->toDateTimeString()
          ],
          [
              'category_name' => 'Vendor Due Payment',
              'created_at' => \Carbon\Carbon::now()->toDateTimeString()
          ]
      ]);
    }
}
