<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor as Vendor;
use App\Product as Product;
use App\Inventorie as Inventorie;
use App\Inventory_historie as Inventory_historie;
use App\Vendor_transection as Vendor_transection;
use App\Expense as Expense;
Use App\Vendor_transection_historie as Vendor_transection_historie;
use Session;

class InventoriesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('storestatus');
  }

  public function index()
  {
    $vendorNames = Vendor::all()->where('soft_delete', 1);
    $productLists = Product::all();
    $inventories = Inventorie::all();
    $inventoryHistories=Inventory_historie::all();


    return view('inventories', compact('vendorNames','productLists','inventoryHistories','inventories'));

  }

  public function addQuantity()
  {
    $invoiceID = $_POST['invoiceID'];
    $vendorID = $_POST['vendorID'];
    $totalPurchase = $_POST['totalPurchase'];
    $amountPaid = $_POST['amountPaid'];
    $fromWhere = $_POST['fromWhere'];

    $publisherTable = Vendor_transection::insert([
      'vendor_id' => $vendorID,
      'invoice_id' => $invoiceID,
      'total_purchase' =>   $totalPurchase,
      'amount_paid'=> $amountPaid,
      'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
    ]);
    $paymentHistory = Vendor_transection_historie::insert([
      'vendor_id' => $vendorID,
      'invoice_id' => $invoiceID,
      'amount_paid' => $amountPaid,
      'from_where' => $fromWhere,
      'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
    ]);
    $vendorName = Vendor::find($vendorID);

    if($fromWhere == 1)
    {
      $expenseTable = Expense::insert([
        'expense_categorie_id' => 2,
        'amount' => $amountPaid,
        'reason' => $vendorName->vendor_name,
        'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
      ]);
    }


    foreach ( $_POST['productID'] as  $key => $value) {


      $updateInventory = Inventorie::where('product_id',$_POST['productID'][$key])->increment(
        'quantity',$_POST['bookQuantity'][$key]);

        if($updateInventory){
          $insertInformationIntoInventoryHistory = Inventory_historie::insert([
            'product_id' =>$_POST['productID'][$key],
            'quantity' =>   $_POST['bookQuantity'][$key],
            'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
          ]);
          Session::flash('bookAdded', "Products added Successfully Added!");
        }
      }
      return redirect('inventories');
    }

    public function productList()
    {
      $vendor = $_POST['vendor'];
      $value = Product::all()->where('vendor_id',$vendor);
      echo $value;

    }
  }
