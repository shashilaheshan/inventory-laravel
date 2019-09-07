<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
  protected $fillable = ['soft_delete','category_name'];
}
