<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor as Vendor;
use App\Expense as Expense;
Use App\Vendor_transection as Vendor_transection;
Use App\Inventory_historie as Inventory_historie;
Use App\Vendor_transection_historie as Vendor_transection_historie;
use Illuminate\Support\Facades\Redirect;
use Session;

class VendorController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('storestatus');
  }
  public function index()
  {
    $vendorListings = Vendor::all()->where('soft_delete', 1);
    return view('vendor', compact('vendorListings'));
  }
  public function addVendor(){
    $insertVendor = Vendor::insert([
      'vendor_name' => $_POST['name'],
      'phone_number' => $_POST['phoneNo'],
      'address' => $_POST['address'],
      'email_address' => $_POST['emailAddress'],
      'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
    ]);
    if($insertVendor){
      return redirect('vendors');
    }
    else {
      echo "Something Gone Wrong publisher add!";
    }
  }
  public function updateVendor(){
    $id = $_POST['id'];
    $vendorName = $_POST['editName'];
    $vendorPhone = $_POST['editPhoneNo'];
    $vendorAddress = $_POST['editAddress'];
    $vendorEmailAddress = $_POST['editEmailAddress'];

    $updateVendor = Vendor::find($id)->update([
      'vendor_name' => $vendorName,
      'phone_number'=>$vendorPhone,
      'address'=>$vendorAddress,
      'email_address'=>$vendorEmailAddress]);
      if($updateVendor){
        return redirect('vendors');
      }
      else {
        echo "Something Gone Wrong at updating Vendor!";
      }
    }
    public function updateSoftStatus(){
      $id = $_POST['softID'];
      $softStatus = $_POST['softStatus'];

      $updateSoftStatus = Vendor::find($id)->update([
        'soft_delete' => $softStatus]);
        if($updateSoftStatus){
          return redirect('vendors');
        }
        else {
          echo "Something Gone Wrong at delete vendor!";
        }
      }
      public function vendorLedger(){
        $vendorsTransections = Vendor_transection::groupBy('vendor_id')
        ->selectRaw('vendor_id,sum(total_purchase) as purchase_sum, sum(amount_paid) as paid_sum')
        ->get();

        return view('vendorledger', compact('vendorsTransections'));
      }

      public function vendorLedgerdetails($vendor_id='')
      {
        $vendorInfoFromDb  = Vendor_transection::where('vendor_id',$vendor_id)->firstorfail();
        $vendorInfoFromDb  = Vendor_transection::all()->where('vendor_id', $vendor_id);
        $vendorPayments  = Vendor_transection_historie::all()->where('vendor_id', $vendor_id);
        $vendorName = Vendor::find($vendor_id);
        return view('vendorLedgerdetails',compact('vendorInfoFromDb','vendorPayments','vendorName'));
      }



      public function updateVendorPayment()
      {

        $invoiceID = $_POST['invoiceId'];
        $paymentAmount = $_POST['paymentAmount'];
        $vendorID = $_POST['vendor_id'];
        $fromWhere = $_POST['fromWhere'];

        $vendorName = Vendor::find($vendorID);

        $updateVendorTransection = Vendor_transection::where('invoice_id',$invoiceID)->increment('amount_paid', $paymentAmount);
        $paymentHistory = Vendor_transection_historie::insert([
          'vendor_id' => $vendorID,
          'invoice_id' => $invoiceID,
          'amount_paid' => $paymentAmount,
          'from_where' => $fromWhere,
          'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
        ]);
        if($fromWhere == 1)
        {
          $expenseTable = Expense::insert([
            'expense_categorie_id' => 2,
            'amount' => $paymentAmount,
            'reason' => $vendorName->vendor_name,
            'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
          ]);
        }
        else{
          $expenseTable = 1; //otherwise it will say Undefined variable when you will select payment from hand cash
        }

        if($updateVendorTransection && $expenseTable && $paymentHistory){
          Session::flash('paymentamountadded', "Payment Successfully Added!");
          return Redirect::back();
        }
        else {
          echo "Something Gone Wrong at update Vendor Payment!";
        }
      }
      public function purchasereport()
      {
        $purchaseReportLists = Inventory_historie::all();
        return view('purchasereport',compact('purchaseReportLists'));
      }
    }
