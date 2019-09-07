<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  public function giveMeVendorName(){
    return Vendor::where('id', $this->vendor_id)->first()->vendor_name;
  }
  public function inventorie(){
        return $this->hasOne('App\Inventorie');
  }
  public function categoryName()
  {
    return Categories::where('id', $this->category)->first()->category_name;
  }
}
