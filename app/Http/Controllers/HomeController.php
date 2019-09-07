<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;
use Charts;
use DB;
use Hash;
use Session;
use Redirect;
use App\Expense as Expense;
use App\Sale as Sale;
use App\Expense_categorie as Expense_categorie;
use App\Customer as Customer;
use App\Customer_transection_historie as Customer_transection_historie;
use App\Invoice as Invoice;
use App\Vendor as Vendor;
use App\Store_statu as Store_statu;
use App\Setting as Setting;
use App\User as User;
use App\HumanResource as HumanResource;
use App\Product as Product;


class HomeController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('storestatus');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {

    $currency = CommonSetting::currency();
    if($currency == 'USD'){
      $currency = "$";
    }
    else if($currency == 'BDT'){
      $currency = "৳";
    }
    else if($currency == 'GBP'){
      $currency = "£";
    }
    else if($currency == 'EUR'){
      $currency = "€";
    }
    else if($currency == 'INR'){
      $currency = "₹";
    }
    $numberOfVendorscount = Vendor::where('soft_delete', '=', 1)->count();
    $numberOfCustomerscount = Customer::where('soft_delete', '=', 1)->where('customer_name', '!=', 'Walk In Customer')->count();
    $todaysExpense = Expense::whereDate('created_at', \Carbon\Carbon::now(CommonSetting::timezone())->toDateString())
    ->selectRaw('sum(amount) as todays_expense')
    ->get();
    $numberOfUserscount = User::all()->where('id','<>',1)->where('password','<>','deleteduser')->count();

    $dataForexpensesOfLastSevenDay = DB::table('expenses')
                     ->select(DB::raw('sum(amount) as sumof, DATE(created_at) as date'))
                     ->where('created_at', '>', \Carbon\Carbon::now(CommonSetting::timezone())->subWeek()->toDateString())
                     ->groupBy('date')
                     ->get();
    //barchart
    $expensesOfLastSevenDay = Charts::create('bar', 'highcharts')
                 ->title('Last 7 Days Expense')
                 ->elementLabel('Total Expense')
                 ->labels($dataForexpensesOfLastSevenDay->pluck('date'))
                 ->values($dataForexpensesOfLastSevenDay->pluck('sumof'))
                 ->responsive(true);

    //expense chart of one month
    $expenseListings = Expense::whereDate('created_at', \Carbon\Carbon::now(CommonSetting::timezone())->toDateString())->get();
    $totalExpense = Expense::whereDate('created_at', \Carbon\Carbon::now(CommonSetting::timezone())->toDateString())
    ->selectRaw('sum(amount) as total_Expense')
    ->get();
    $salesListings = Customer_transection_historie::whereDate('created_at', \Carbon\Carbon::now(CommonSetting::timezone())->toDateString())->get();
    $totalSale = Customer_transection_historie::whereDate('created_at', \Carbon\Carbon::now(CommonSetting::timezone())->toDateString())
    ->selectRaw('sum(amount_paid) as total_Sale')
    ->get();

    //7 months customer adding Chart
    $currentYear = \Carbon\Carbon::now(CommonSetting::timezone())->format('Y');
    $customerLastSevenMonthsChart = Charts::database(Customer::all()->where('id', '!=', 1), 'bar', 'highcharts')
    ->title("Customer Last 7 Months")
    ->elementLabel("Customer Amount")
    ->responsive(true)
    ->groupByMonth($currentYear, true)
    ->lastByMonth(7);

    //donut
    $expenseCategoryDonut = Charts::database(Expense::all(), 'pie', 'c3')
    ->title('Expense Category')
    ->responsive(true)
    ->groupBy('expense_categorie_id',null,[1 => 'Withdraw At Store Close', 2 => 'Vendor Due Payment']);
    //donut-end

    //7days products chart
    $productSaleOfLastSevenDay = Charts::database(Sale::all(), 'line', 'highcharts')
    ->title("Sales Of Last 7 Days")
    ->elementLabel("Amount of Product Sale")
    ->dimensions(1000, 500)
    ->responsive(true)
    ->lastByDay(7, true);

    //customer chart
    $dataForRevenueFromCustomerTransectionHistories = DB::table('customer_transection_histories')
    ->select(DB::raw('sum(amount_paid) as sumof, Month(created_at) as date'))
    ->groupBy('date')
    ->get();

    //expense and revenue chart
    $dataForRevenueFromExpenses = DB::table('expenses')
    ->select(DB::raw('sum(amount) as sumofexpense, Month(created_at) as date'))
    ->groupBy('date')
    ->get();

    //highchart
    $revenue = Charts::multi('areaspline', 'highcharts')
    ->title('Monthly Stat')
    ->elementLabel("1=Jan;2=Feb...")
    ->colors(['#ff0000', '#87C1FB'])
    ->labels($dataForRevenueFromExpenses->pluck('date'))
    ->dataset('Expenses',  $dataForRevenueFromExpenses->pluck('sumofexpense'))
    ->dataset('Sales',  $dataForRevenueFromCustomerTransectionHistories->pluck('sumof'));

    return view('home', compact('currency','numberOfVendorscount','numberOfCustomerscount','todaysExpense','numberOfUserscount','expensesOfLastSevenDay','customerLastSevenMonthsChart','expenseListings','salesListings','totalExpense','totalSale','expenseCategoryDonut','productSaleOfLastSevenDay','revenue'));
  }


  public function profile()
  {
    return view('profile',array('user' => Auth::user()) );
  }


  public function profile_edit(Request $request){

    // Handle the user upload of avatar
    if($request->hasFile('avatar')){
      $user = Auth::user();
      if($user->avatar != 'default.jpg'){
        unlink(base_path('resources/assets/uploads/avatars/'. $user->avatar));
      }
      $avatar = $request->file('avatar');

      $filename = $user->id . '.' . $avatar->getClientOriginalExtension();
      Image::make($avatar)->resize(300, 300)->save( base_path('resources/assets/uploads/avatars/' . $filename ) );
      $user->avatar = $filename;
      $user->save();
    }
    return redirect('profile');
  }

  public function password_change()
  {
    $User = User::find(Auth::user()->id);
    if(Hash::check($_POST['old_password'], $User['password'])){
      $User->password = bcrypt($_POST['new_password']);
      $User->save();
      Session::flash('passwordChangeStatusYes', "Password Changed Sucessfully. Please Login Again with your new password.");
      return Redirect::back();
    }
    else {
      Session::flash('passwordChangeStatusNo', "Old Password Does Not Match.");
      return Redirect::back();
    }
  }

}
