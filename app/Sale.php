<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  public function getProductName(){
    return Product::where('id', $this->product_id)->first()->product_name;
  }
}
