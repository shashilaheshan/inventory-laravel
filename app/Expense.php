<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
  public function giveMeExpenseCategoryName(){
    return Expense_categorie::where('id', $this->expense_categorie_id)->first()->category_name;
  }
}
