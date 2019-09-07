<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer as Customer;
use Charts;

class CustomerController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('storestatus');
  }
  public function index()
  {
    $customerInfos = Customer::all()->where('soft_delete', 1)->where('customer_name', '!=', 'Walk In Customer');
    return view('customer', compact('customerInfos'));
  }

  public function addCustomer(){
    
    $insertCustomerStatus = Customer::insert([
      'customer_name' => $_POST['customerName'],
      'phone_number' => $_POST['phoneNumber'],
      'address' => $_POST['address'],
      'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
    ]);
    if($insertCustomerStatus){
      return redirect('customers');
    }
    else {
      echo "Something Gone Wrong with customer insertion!";
    }
  }
  public function addCustomerFromInvoice(){

    $insertCustomerStatus = Customer::insert([
      'customer_name' => $_POST['customerName'],
      'phone_number' => $_POST['phoneNumber'],
      'address' => $_POST['address'],
      'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
    ]);
    if($insertCustomerStatus){
      return redirect('invoice');
    }
    else {
      echo "Something Gone Wrong with customer insertion!";
    }
  }

  // Update-Customer-profile


  public function updateCustomer(){
    $customerId = $_POST['customerId'];
    $customerName = $_POST['customer_name'];
    $customerPhone = $_POST['phone_number'];
    $customerAddress = $_POST['address'];

    $updateCustomer = Customer::find($customerId)->update([
      'customer_name' => $customerName,
      'phone_number'=>$customerPhone,
      'address'=>$customerAddress,

    ]);
    if($updateCustomer){
      return redirect('customers');
    }
    else {
      echo "Something Gone Wrong at updating Customer!";
    }
  }

  // end-Update-Customer-profile

  // Delete-Customer-Information

  public function updateCustomerSoftStatus(){
    $id = $_POST['softID'];
    $softStatus = $_POST['softStatus'];

    $updateSoftStatus = Customer::find($id)->update([
      'soft_delete' => $softStatus]);
      if($updateSoftStatus){
        return redirect('customers');

      }
      else {
        echo "Something Gone Wrong at delete Publisher!";
      }
    }

    // end-of-Delete-Customer-Information

  }
