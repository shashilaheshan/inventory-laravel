<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor as Vendor;
use App\Customer as Customer;


class RestoreController extends Controller
{
  //check where login or not
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('storestatus');
  }
  public function index()
  {
    $deletedVendorLists = Vendor::where('soft_delete', '=', 2)->get();
    $deletedCustomerLists = Customer::where('soft_delete', '=', 2)->get();
    return view('restore', compact('deletedVendorLists','deletedCustomerLists'));
  }
  public function restoreVendor()
  {
    $vendorId = $_POST['whichVendor'];
    $restoreVendorStatus = Vendor::find($vendorId)->update(['soft_delete' => 1]);
    if($restoreVendorStatus){
      return redirect('restore');
    }
    else {
      echo "Something Gone Wrong at Restore Vendor!";
    }
  }
  public function restoreCustomer()
  {
    $customerId = $_POST['whichCustomer'];
    $restoreCustomerStatus = Customer::find($customerId)->update(['soft_delete' => 1]);
    if($restoreCustomerStatus){
      return redirect('restore');
    }
    else {
      echo "Something Gone Wrong at Restore Customer!";
    }
  }
}
