<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
  public function productName(){
    return Product::where('id', $this->product_id)->first()->product_name;
  }
}
