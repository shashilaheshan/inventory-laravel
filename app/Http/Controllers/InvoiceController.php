<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting as Setting;
use App\Product as Product;
use App\Inventorie as Inventorie;
use App\Customer as Customer;
use App\Invoice as Invoice;
use App\Tempsale as Tempsale;
use App\Sale as Sale;
use App\Customer_transection as Customer_transection;
use App\Customer_transection_historie as Customer_transection_historie;
use Auth;


class InvoiceController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('storestatus');
    }
    public function index()
    {
        $companyInfo = Setting::findorfail(1);
        $productLists =Inventorie::all()->where('quantity','<>',0);
        $customerLists =Customer::all();

        $userId = Auth::id();
        $check = Tempsale::where('user_id',$userId)->exists();

        //if one invoice is running

        if ($check==1){
            $customer = Tempsale::all()->where('user_id',$userId)->first();
            $tempsales = Tempsale::all()->where('user_id',$userId);

            $customerInfo = Customer::find($customer->customer_id);
            return view('invoice', compact('companyInfo','productLists','customerLists','tempsales','customerInfo','customer'));
        }

        else
        {   //new invoice generation
            $newInvoice = Invoice::insertGetId([
                'customer_id' => 0,
                'total_amount' => 0,
                'total_quantity' => 0,
                'payment_method'=> 0,
                'paid_amount'=> 0,
                'soft_delete'=> 1,
                'tax'=> 0,
                'reduced'=> 0,
                'delivery'=> 0,
                'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString()
            ]);
            return view('invoice', compact('companyInfo','productLists','customerLists','newInvoice'));
        }
    }




    public function inventoriesData()
    {
        $bookName = $_POST['bookName'];
        $info = Inventorie::all()->where('product_id',$bookName);
        echo $info;
    }

    public function customerData()
    {
        $customerID = $_POST['customerID'];
        $info = Customer::all()->where('id',$customerID);
        echo $info;
    }

    public function tempSales()
    {
        $userId = Auth::id();

        $bookID = $_POST['bookID'];
        $bookName = $_POST['bookName'];
        $bookQuantity= $_POST['bookQuantity'];
        $bookPrice= $_POST['bookPrice'];
        $total_price= $_POST['total_price'];
        $bookPercentage= $_POST['bookPercentage'];
        $net_price= $_POST['net_price'];
        $customerID= $_POST['customerID'];
        $invoice= $_POST['invoice'];



        $temporary = Tempsale::insertGetId([
            'user_id'=> $userId,
            'invoice_id'=> $invoice,
            'customer_id'=> $customerID,
            'book_id'=> $bookID,
            'book_name'=> $bookName,
            'book_quantity'=> $bookQuantity,
            'book_price'=> $bookPrice,
            'total_price'=> $total_price,
            'discount'=> $bookPercentage,
            'net_price'=> $net_price,
            'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString()
        ]);
        $inventory = Inventorie::where('product_id',$bookID)->decrement('quantity',$bookQuantity);
        echo $temporary;
    }

    public function postsale()
    {
        $customerID = $_POST['customerID'];
        $invoiceNO = $_POST['invoiceNO'];
        $netAmount = $_POST['netAmount'];
        $payment = $_POST['payment'];
        $paid_amount = $_POST['paid_amount'];
        $tax= $_POST['taxVal'];
        $reduced = $_POST['reduced'];
        $delivery = $_POST['delivery'];
        $quantity = 0;
        $userId = Auth::id();


        foreach($_POST['book_quantity'] as  $key => $value)
        {
            $quantity = $quantity + $_POST['book_quantity'][$key];
            $saleTable = Sale::insert([
                'invoice_id' =>$invoiceNO,
                'product_id' =>   $_POST['book_id'][$key],
                'product_quantity' =>   $_POST['book_quantity'][$key],
                'percentage' =>   $_POST['discount'][$key],
                'total_amount' =>   $_POST['total_price'][$key],
                'net_price' =>   $_POST['net_price'][$key],
                'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
            ]);

        }
        $customerTransection = Customer_transection::insert([
            'invoice_id' =>$invoiceNO,
            'customer_id' =>  $customerID,
            'total_purchase' =>   $netAmount,
            'amount_paid' =>   $paid_amount,
            'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
        ]);
        if($paid_amount != 0)
        {
            $customerPaymentHistory = Customer_transection_historie::insert([
                'invoice_id' =>$invoiceNO,
                'customer_id' =>  $customerID,
                'amount_paid' =>   $paid_amount,
                'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
            ]);
        }

        $updateInvoice = Invoice::where('id',$invoiceNO)->update([
            'customer_id' =>$customerID,
            'total_amount' => $netAmount,
            'total_quantity' => $quantity,
            'payment_method' => $payment,
            'paid_amount' => $paid_amount,
            'soft_delete' =>2,
            'tax'=> $tax,
            'reduced'=> $reduced,
            'delivery'=> $delivery,
            'updated_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString()
        ]);
        $deleteTempSale = Tempsale::where('user_id', $userId)->delete();

    }

    public function deleteTemp()
    {   $userId = Auth::id();
        $getTempSales = Tempsale::where('user_id', $userId)->get();
        foreach($getTempSales as $getTempSale)
        {
            $inventory = Inventorie::where('product_id',$getTempSale->book_id)->increment('quantity',$getTempSale->book_quantity);
        }

        $deleteTempSale = Tempsale::where('user_id', $userId)->delete();
        return redirect()->back();
    }

    public function delSaleRow()
    {
        $rowID = $_POST['temp'];
        $getTempSale = Tempsale::find($rowID);

        $inventory = Inventorie::where('product_id',$getTempSale->book_id)->increment('quantity',$getTempSale->book_quantity);
        $deleteTempSale = Tempsale::find($rowID)->delete();
    }
}
