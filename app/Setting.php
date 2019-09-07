<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
  protected $fillable = ['company_name', 'phone_number', 'address', 'currency','time_zone','default_vat','delivery_charge'];
}
