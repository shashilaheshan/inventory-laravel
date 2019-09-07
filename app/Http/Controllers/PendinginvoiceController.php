<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tempsale as Tempsale;
use App\Inventorie as Inventorie;

class PendinginvoiceController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('storestatus');
      $this->middleware('userrole'); //this will prevent staff from seeting this blade
    }
    public function index()
    {
        $pendingInvoiceProductLists = Tempsale::all();
        return view('pendinginvoice' , compact('pendingInvoiceProductLists'));
    }
    public function releasePendingInvoice()
    {
        $rowID = $_POST['whichTempsaleId'];
        $getTempSale = Tempsale::find($rowID);

        $inventory = Inventorie::where('product_id',$getTempSale->book_id)->increment('quantity',$getTempSale->book_quantity);
        $deleteTempSale = Tempsale::find($rowID)->delete();
        if($deleteTempSale){
            return redirect('pendinginvoice');
        }
        else{
            echo "Something wrong with release pending invoice";
        }
    }
}
