<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tempsale extends Model
{
  public function giveMeStaffNameWhoseInvoiceIsPending(){
    return User::where('id', $this->user_id)->first()->name;
  }
}
