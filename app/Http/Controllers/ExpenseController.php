<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense as Expense;
use App\Invoice as Invoice;
use App\Expense_categorie as Expense_categorie;
use PDF;
use DB;
use Charts;
use Image;

class ExpenseController extends Controller
{
  //check where login or not
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('storestatus');
  }

  public function index()
  {

    $expenseListings = Expense::all();
    $expenseCategories = Expense_categorie::all()->where('id', '!=', 1)->where('id', '!=', 2); //because we don't want general category get edited
    return view('expense', compact('expenseListings','expenseCategories'));

  }


  public function addExpense()
  {
    $insertStatus = Expense::insert([
      'expense_categorie_id' => $_POST['category'],
      'amount' => $_POST['amount'],
      'reason' => $_POST['reason'],
      'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
    ]);
    if($insertStatus){
      return redirect('expense');
    }
    else {
      echo "Something Gone Wrong!";
    }
  }

  public function addExpenseCategory()
  {
    $insertCategoryStatus = Expense_categorie::insert([
      'category_name' => $_POST['categoryName'],
      'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
    ]);
    if($insertCategoryStatus){
      return redirect('expense');
    }
    else {
      echo "Something Gone Wrong at inserting expense category!";
    }
  }

  public function editExpenseCategory(){
    $oldCategoryId = $_POST['oldCategoryId'];
    $newCategoryName = $_POST['newCategoryName'];

    $categoryUpdateStatus = Expense_categorie::find($oldCategoryId)->update(['category_name' => $newCategoryName]);
    if($categoryUpdateStatus){
      return redirect('expense');
    }
    else {
      echo "Something Gone Wrong at updating expense category!";
    }
  }
}
