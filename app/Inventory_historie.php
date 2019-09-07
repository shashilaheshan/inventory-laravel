<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory_historie extends Model
{
  public function giveMeProductName(){
    return Product::where('id', $this->product_id)->first()->product_name;
  }
}
