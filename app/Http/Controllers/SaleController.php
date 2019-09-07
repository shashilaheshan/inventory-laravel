<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale as Sale;
use App\Invoice as Invoice;
use App\Setting as Setting;
use App\Customer;


class SaleController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('storestatus');
  }
  public function index()
  {
    $salesListings = Invoice::where('soft_delete','=',2)->get();
    return view('sale', compact('salesListings'));

  }

  public function saleDetails($invoice_id='')
  {

    $invoiceInfos = Invoice::findorfail($invoice_id);
    $customerInfo = Customer::findorfail($invoiceInfos->customer_id);
    $invoice = Sale::where('invoice_id', $invoice_id)->firstOrFail();
    $saleDetails = Sale::where('invoice_id','=', $invoice_id)->get();
    return view('saledetail', compact('saleDetails','invoice','invoiceInfos','customerInfo'));
  }

}
