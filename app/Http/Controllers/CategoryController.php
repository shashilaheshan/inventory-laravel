<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories as Categories;

class CategoryController extends Controller
{
  //check where login or not
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('storestatus');
  }
  public function index()
  {
    $categoryListings = Categories::all()->where('soft_delete', 1);
    return view('category', compact('categoryListings'));
  }
  public function addCategory()
  {
    $insertCategoryStatus = Categories::insert([
      'category_name' => $_POST['categoryName']
    ]);
    if($insertCategoryStatus){
      return redirect('categories');
    }
    else {
      echo "Something Gone Wrong with category input!";
    }
  }
  
  public function deleteCategory(){
    $deleteThisId = $_POST['deleteThisId'];
    $editCategory = $_POST['editCategory'];

    $categoryDeleteStatus = Categories::find($deleteThisId)->update(['category_name' => $editCategory]);
    if($categoryDeleteStatus){
      return redirect('categories');
    }
    else {
      echo "Something Gone Wrong at updating category!";
    }
  }

}
