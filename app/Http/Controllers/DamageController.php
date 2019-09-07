<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product as Product;
use App\Damage as Damage;
use App\Inventorie as Inventorie;
use Auth;


class DamageController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('storestatus');
  }

  public function index()
  {
    $productLists = Inventorie::all()->where('quantity','<>',0);
    $damageListings = Damage::all();
    return view('damage', compact('productLists','damageListings'));
  }

  public function damageList()
  {
    $value = $_POST['product_id'];

    $productQuantity = Inventorie::where('product_id',$value)->first();
    echo $productQuantity->quantity;
  }

  public function damageIssue(){
    $product_id = $_POST['product_name'];
    $damageQuantity = $_POST['quantity'];
    $damageReason = $_POST['reason'];

    $minusFromInventorie = Inventorie::where('product_id',$product_id)->decrement('quantity' , $damageQuantity);
    if($minusFromInventorie){
      $insertIntoDamage = Damage::insert([
        'product_id'=>$product_id,
        'quantity'=>$damageQuantity,
        'reason'=>$damageReason,
        'issued_by'=>Auth::user()->name,
        'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString()
      ]);
      return redirect('damages');
    }
    else {
      echo "Something Gone Wrong at Damage!";
    }
  }


}
