<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $fillable = ['customer_name', 'phone_number','address','soft_delete' ,'created_at'];
  protected $table = 'customers';
}
