<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
  protected $fillable = ['vendor_name', 'phone_number', 'address','email_address', 'created_at','soft_delete'];
  protected $table = 'vendors';
}
