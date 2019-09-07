<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('settings', function (Blueprint $table) {
          $table->increments('id');
          $table->string('company_name');
          $table->string('phone_number');
          $table->string('address');
          $table->string('currency');
          $table->integer('default_vat');
          $table->string('logo');
          $table->string('time_zone');
          $table->integer('delivery_charge');
          $table->timestamps();
      });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
      Schema::dropIfExists('settings');
  }
}
