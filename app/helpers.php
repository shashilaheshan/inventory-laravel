<?php

function getAlertBookAmount(){
  return \App\Inventorie::whereRaw('alert_quantity >= quantity')->count();
}

function getTodaysDate(){
  return \Carbon\Carbon::now(\App\Http\Controllers\CommonSetting::timezone())->toDateString();
}

function getTheCurrency(){
  return \App\Http\Controllers\CommonSetting::currency();
}

function getTotalEarningOfToday(){
  $getTotalTodayEarnings = \App\Customer_transection_historie::whereDate('created_at', \Carbon\Carbon::now(\App\Http\Controllers\CommonSetting::timezone())->toDateString())
  ->selectRaw('sum(amount_paid) as todays_earning')
  ->get();
  foreach ($getTotalTodayEarnings as $getTotalTodayEarning) {
    if($getTotalTodayEarning->todays_earning == null){
      return 0;
    }
    return $getTotalTodayEarning->todays_earning;
  }
}

function getTotalExpenseOfToday(){
  $getTotalTodayExpenses = \App\Expense::whereDate('created_at', \Carbon\Carbon::now(\App\Http\Controllers\CommonSetting::timezone())->toDateString())
  ->selectRaw('sum(amount) as todays_expense')
  ->get();
  foreach ($getTotalTodayExpenses as $getTotalTodayExpense) {
    if($getTotalTodayExpense->todays_expense == null){
      return 0;
    }
    return $getTotalTodayExpense->todays_expense;
  }
}
function getTheCashInHand(){
  $cashInHand = \App\Store_statu::find(1);
  return $cashInHand->cash_in_hand;
}
function getTheCompanyName(){
  $companyName = \App\Setting::find(1);
  return $companyName->company_name;
}
function getTheCompanyAddress(){
  $companyName = \App\Setting::find(1);
  return $companyName->address;
}
function getTheCompanyPhnNo(){
  $companyName = \App\Setting::find(1);
  return $companyName->phone_number;
}

function getTheCompanyFavicon(){
  $companyFavicon = \App\Setting::find(1);
  return $companyFavicon->logo;
}
function getTheVat(){
  $companyDefaultVat = \App\Setting::find(1);
  return $companyDefaultVat->default_vat;
}
function getTheDeliveryCharge(){
  $companyDefaultVat = \App\Setting::find(1);
  return $companyDefaultVat->delivery_charge;
}
?>
