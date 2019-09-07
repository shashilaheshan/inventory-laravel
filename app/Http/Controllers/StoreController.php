<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Setting as Setting;
use App\Store_statu as Store_statu;
use App\Expense as Expense;
use App\Customer_transection_historie as Customer_transection_historie;


class StoreController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */

  public function index()
  {
    $companyInfo = Setting::findorfail(1);
    return view('storeopen', compact('companyInfo'));
  }

  public function changeStoreClose()
  {
    $may_have = $_POST['mayHave'];
    $take_from_cash = $_POST['takeFromCash'];
    if(!$may_have)
    {
      $may_have=0;
    }
    if(!$take_from_cash)
    {
      $take_from_cash=0;
    }
    if($take_from_cash != 0){
      $insertIntoExpenseWhenStoreClose = Expense::insert([
        'expense_categorie_id' => 1,
        'amount' => $take_from_cash,
        'reason' => 'Withdraw',
        'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
      ]);
      if(!$insertIntoExpenseWhenStoreClose){
        echo "Something Gone Wrong Insert Into Expense When Store Close!";
      }
    }
    $cash_in_hand = $may_have - $take_from_cash;
    $store_status = $_POST['storeStatus'];
    $updateStoreStatus = Store_statu::find(1)->update([
      'cash_in_hand' => $cash_in_hand,
      'store_close' => $store_status]);
      if($updateStoreStatus){
        return redirect('home');
      }
      else {
        echo "Something Gone Wrong at updating Store Status!";
      }
    }

    public function changeStoreOpen()
    {
      $previousCashInHand = $_POST['previousCashInHand'];
      $extraCashInHand = $_POST['extraCashInHand'];
      if(!$previousCashInHand)
      {
        $previousCashInHand=0;
      }
      if(!$extraCashInHand)
      {
        $extraCashInHand=0;
      }
      if($extraCashInHand != 0){
        $insertIntoCustomerTransactionHistory = Customer_transection_historie::insert([
          'customer_id' => 0,
          'invoice_id' => 0,
          'amount_paid' => $extraCashInHand,
          'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
        ]);
        if(!$insertIntoCustomerTransactionHistory){
          echo "Something Gone Wrong Insert Into Customer Transaction History!";
        }
      }
      $store_status = $_POST['storeStatus'];
      $cash_in_hand = $previousCashInHand + $extraCashInHand;
      $updateStoreStatus = Store_statu::find(1)->update([
        'cash_in_hand' => $cash_in_hand,
        'store_close' => $store_status]);
        if($updateStoreStatus){
          return redirect('home');
        }
        else {
          echo "Something Gone Wrong at updating Store Status Open!";
        }
      }
    }
