<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor_transection extends Model
{
  public function getVendorName(){
    return Vendor::where('id', $this->vendor_id)->first()->vendor_name;
  }
}
