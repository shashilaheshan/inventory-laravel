<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_transection_historie extends Model
{
  public function getCustomerName(){
    return Customer::where('id', $this->customer_id)->first()->customer_name;
  }
}
