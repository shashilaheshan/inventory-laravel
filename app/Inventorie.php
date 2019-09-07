<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventorie extends Model
{
  protected $fillable = ['product_id', 'quantity',  'created_at'];
  protected $table = 'inventories';

  public function product(){
        return $this->belongsTo('App\Product');
  }

}
