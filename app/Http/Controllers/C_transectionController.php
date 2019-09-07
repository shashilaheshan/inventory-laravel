<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice as Invoice;
use App\Customer_transection as Customer_transection;
use App\Customer as Customer;
use App\Customer_transection_historie as Customer_transection_historie;
use Illuminate\Support\Facades\Redirect;
use Session;



class C_transectionController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('storestatus');
  }

  public function index()
  {
       $ledgerListings = Customer_transection::groupBy('customer_id')
       ->selectRaw('customer_id, sum(total_purchase) as totalAmount, sum(amount_paid) as totalPaid')->get();
       return view('customerledger', compact('ledgerListings'));

  }


  public function customerLedgerDetails($customer_id=''){
    $customerInfoFromDb = Invoice::where('customer_id', $customer_id)->firstOrFail();
    $customerInfoFromDb  = Invoice::all()->where('customer_id', $customer_id);
    $customerPayments  = Customer_transection_historie::all()->where('customer_id', $customer_id);
    $customerName = Customer::find($customer_id);

    return view('customerledgerdetails',compact('customerInfoFromDb','customerPayments','customerName'));
  }


  public function updateCustomerPayment()
  {

    $invoiceID = $_POST['id'];
    $paymentAmount = $_POST['paymentAmount'];
    $customerId = $_POST['customerId'];

    $updateCustomerInvoice = Invoice::find($invoiceID)->increment('paid_amount', $paymentAmount);
    
    $updateCustomerTransection = Customer_transection::where('invoice_id','=',$invoiceID)->increment('amount_paid', $paymentAmount);
    $insertHistory = Customer_transection_historie::insert([
           'customer_id' => $customerId,
           'invoice_id' => $invoiceID,
           'amount_paid' => $paymentAmount,
           'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
       ]);

      if($updateCustomerTransection && $updateCustomerInvoice && $insertHistory){
        Session::flash('paymentamountadded', "Customer Payment Successfully Added!");
        return Redirect::back();
      }
      else {
        echo "Something Gone Wrong at update Customer Payment!";
      }
  }


}
