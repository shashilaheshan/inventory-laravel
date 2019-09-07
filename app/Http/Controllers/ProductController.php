<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor as Vendor;
use App\Product as Product;
use App\Inventorie as Inventorie;
use App\Setting as Setting;
use App\Categories;

class ProductController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('storestatus');
    }
  public function index()
    {
        $vendorNames = Vendor::all()->where('soft_delete', 1);
        $categories = Categories::all()->where('soft_delete', 1);
        $productLists = Product::with('inventorie')->get();
        return view('product', compact('vendorNames','productLists','categories'));
    }
  public function addProduct()
    {
      //add product into product table
        $insertProduct = Product::insertGetId([
           'product_name' => $_POST['productName'],
           'product_code' => $_POST['productCode'],
           'vendor_id' => $_POST['vendorName'],
           'category' => $_POST['category'],
           'alert_quantity' => $_POST['alertQuantity'],
           'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
          ]);
            if($insertProduct){
                 //$insertProduct will return last inserted id as we use insertGetId()
                   // add product into Inventorie table
                      $insertProductIntoInventory = Inventorie::insert([
                       'product_id' => $insertProduct,
                       'quantity' => 0,
                       'alert_quantity' => $_POST['alertQuantity'],
                       'unit_price' => $_POST['price'],
                       'percentage' => $_POST['percentage'],
                       'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
                      ]);
                  // add product into Inventorie table-end
                    if($insertProductIntoInventory){
                      return redirect('products');
                    }
                    else{
                      echo "Something Gone Wrong Inventorie add!";
                    }
            }
            else {
                 echo "Something Gone Wrong product add!";
            }
      //add product into product table-end
      }

      public function alertProducts()
      {
        $companyInfo = Setting::findorfail(1);
        $alertLists = Inventorie::whereRaw('alert_quantity >= quantity')->get();
        return view('alertproducts', compact('alertLists','companyInfo'));
      }

      public function changeAlertQuanityAndUnitPrice()
      {
        $productId = $_POST['product_name'];
        $alertQuantity = $_POST['alert_quantity'];
        $unitPrice = $_POST['unit_price'];

        $alertQuantityUpdateStatus = Inventorie::where('product_id',$productId)->update(['alert_quantity' => $alertQuantity,'unit_price' => $unitPrice]);
        $alertQuantityUpdateStatus = Product::where('id',$productId)->update(['alert_quantity' => $alertQuantity]);
        if($alertQuantityUpdateStatus){
          return redirect('products');
        }
        else {
          echo "Something Gone Wrong at updating alert quantity!";
        }
      }
}
