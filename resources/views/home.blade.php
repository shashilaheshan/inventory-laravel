@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row text-center">
  <div class="col-xs-6 col-md-3" style="cursor:pointer;color:#FFF" onclick="window.location.href='{{url('/vendors')}}'">
      <div class="panel" style="background-color:#EC5564">
        <div class="panel-heading">
          <h3><span class="fa fa-2x fa-user-o"></span> | {{$numberOfVendorscount}}</h3>
        </div>
        <div class="panel-body">
          <h4><b>Suppliers</b></h4>
        </div>
      </div>
    </div>
    <div class="col-xs-6 col-md-3" style="cursor:pointer;color:#FFF" onclick="window.location.href='{{url('/customers')}}'">
      <div class="panel" style="background-color:#8D6A58">
        <div class="panel-heading">
          <h3><span class="fa fa-2x fa-users"></span> | {{$numberOfCustomerscount}}</h3>
        </div>
        <div class="panel-body">
          <h4><b>Customers</b></h4>
        </div>
      </div>
    </div>
    @if (Auth::user()->role == 'admin')
    <div class="col-xs-6 col-md-3" style="cursor:pointer;color:#FFF" onclick="window.location.href='{{url('/userlist')}}'">
      <div class="panel" style="background-color:#ff704d">
        <div class="panel-heading">
          <h3><span class="fa fa-2x fa fa-address-card-o"></span> | {{$numberOfUserscount}}</h3>
        </div>
        <div class="panel-body">
          <h4><b>Users</b></h4>
        </div>
      </div>
    </div>
    @endif
    <div class="col-xs-6 col-md-3" style="cursor:pointer;color:#FFF" onclick="window.location.href='{{url('/expense')}}'">
      <div class="panel" style="background-color:#00A65A">
        <div class="panel-heading">
          <h3><span class="fa fa-2x fa-money"></span> |
            @foreach($todaysExpense as $todayExpense)
            {{$currency}}@if(!$todayExpense->todays_expense)
            0
            @endif
            {{$todayExpense->todays_expense}}
            @endforeach
          </h3>
        </div>
        <div class="panel-body">
          <h4><b>Expense</b></h4>
        </div>
      </div>
    </div>
    @if (Auth::user()->role == 'staff')
    <div class="col-xs-6 col-md-3" style="cursor:pointer;color:#FFF" onclick="window.location.href='{{url('/damages')}}'">
      <div class="panel" style="background-color:#79C447">
        <div class="panel-heading" style="text-align:center;">
          <h3>
            <span class="fa fa-2x fa-trash-o"></span>
          </h3>
        </div>
        <div class="panel-body" style="text-align:center;">
          <h4><b>Damage Issue</b></h4>
        </div>
      </div>
    </div>
    @endif
  </div>

  <div class="row">
    <div class="col-xs-6 col-md-3" style="cursor:pointer;color:#FFF" onclick="window.location.href='{{url('/products')}}'">
      <div class="panel" style="background-color:#7A5BA9">
        <div class="panel-heading" style="text-align:center;">
          <h3>
            <span class="fa fa-2x fa fa-cubes"></span>
          </h3>
        </div>
        <div class="panel-body" style="text-align:center;">
          <h4><b>Products</b></h4>
        </div>
      </div>
    </div>
    <div class="col-xs-6 col-md-3" style="cursor:pointer;color:#FFF" onclick="window.location.href='{{url('/inventories')}}'">
      <div class="panel" style="background-color:#148CA5">
        <div class="panel-heading" style="text-align:center;">
          <h3><span class="fa fa-2x fa fa-shopping-basket"></span>
          </h3>
        </div>
        <div class="panel-body" style="text-align:center;">
          <h4><b>Purchase</b></h4>
        </div>
      </div>
    </div>
    <div class="col-xs-6 col-md-3" style="cursor:pointer;color:#FFF" onclick="window.location.href='{{url('/invoice')}}'">
      <div class="panel" style="background-color:#3BBACB">
        <div class="panel-heading" style="text-align:center;">
          <h3><span class="fa fa-2x fa-file-text"></span>
          </h3>
        </div>
        <div class="panel-body" style="text-align:center;">
          <h4><b>Sales</b></h4>
        </div>
      </div>
    </div>
    <div class="col-xs-6 col-md-3" style="cursor:pointer;color:#FFF" data-toggle="modal" data-target="#SalesExpenseModal">
      <div class="panel" style="background-color:#66ff99;">
        <div class="panel-heading" style="text-align:center;">
          <h3><span class="fa fa-2x fa-history"></span>
          </h3>
        </div>
        <div class="panel-body" style="text-align:center;">
          <h4><b>History</b></h4>
        </div>
      </div>
    </div>
  </div>
  <!-- Notification of subscribing   -->
  <div class="row text-center">



  </div>

  <!--End of Notification of subscribing   -->
  <div class="row">
    @if (Auth::user()->role == 'admin')
    <div class="col-xs-6 col-md-3" style="cursor:pointer;color:#FFF" onclick="window.location.href='{{url('/pendinginvoice')}}'">
      <div class="panel" style="background-color:#ff944d">
        <div class="panel-heading" style="text-align:center;">
          <h3><span class="fa fa-2x fa-file"></span>
          </h3>
        </div>
        <div class="panel-body" style="text-align:center;">
          <h4><b>Pending Invoice</b></h4>
        </div>
      </div>
    </div>
    @endif
    @if (Auth::user()->role == 'admin')
    <div class="col-xs-6 col-md-3" style="cursor:pointer;color:#FFF" onclick="window.location.href='{{url('/damages')}}'">
      <div class="panel" style="background-color:#79C447">
        <div class="panel-heading" style="text-align:center;">
          <h3>
            <span class="fa fa-2x fa-trash-o"></span>
          </h3>
        </div>
        <div class="panel-body" style="text-align:center;">
          <h4><b>Damage Issue</b></h4>
        </div>
      </div>
    </div>
    @endif
    @if (Auth::user()->role == 'admin')
    <div class="col-xs-6 col-md-3" style="cursor:pointer;color:#FFF" onclick="window.location.href='{{url('/restore')}}'">
      <div class="panel" style="background-color:#FBA824">
        <div class="panel-heading" style="text-align:center;">
          <h3><span class="fa fa-2x fa-window-restore"></span>
          </h3>
        </div>
        <div class="panel-body" style="text-align:center;">
          <h4><b>Restore</b></h4>
        </div>
      </div>
    </div>
    <div class="col-xs-6 col-md-3" style="cursor:pointer;color:#FFF" onclick="window.location.href='{{url('/settings')}}'">
      <div class="panel" style="background-color:#9B395E">
        <div class="panel-heading" style="text-align:center;">
          <h3><span class="fa fa-2x fa-wrench"></span>
          </h3>
        </div>
        <div class="panel-body" style="text-align:center;">
          <h4><b>Settings</b></h4>
        </div>
      </div>
    </div>
    @endif
  </div>

  @if (Auth::user()->role == 'admin')
  <div class="row">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading"><h3>Sales Of Last 7days</h3></div>
        <div class="panel-body">
          <!-- This will render the chart -->
          {!! $productSaleOfLastSevenDay->render() !!}
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading"><h3>Expense Of Last 7days</h3></div>
        <div class="panel-body">
          <!-- This will render the chart -->
          {!! $expensesOfLastSevenDay->render() !!}
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading"><h3>Last 7 months Customer rate</h3></div>
        <div class="panel-body">
          {!! $customerLastSevenMonthsChart->render() !!}
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading"><h3>Monthly Stat</h3></div>
        <div class="panel-body">
          {!! $revenue->render() !!}
        </div>
      </div>
    </div>
  </div>
  @endif
</div>

<!-- Today's Sales and expense modal -->

<!-- Modal -->


<div class="modal fade" id="SalesExpenseModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Today's Sales And Expense</h3>
      </div>
      <div class="modal-body container">
        <div class="col-xs-12 col-md-5">
          <!-- <p>This is a Sales.</p> -->
          <h4>Sales</h4>
          {{getTodaysDate()}}
          <div class="panel-body">
            <table class="table" id="sale-list-table">
              <thead>
                <th>Invoice ID</th>
                <th>Paid Amount</th>
              </thead>
              <tbody>
                @foreach($salesListings as $salesListing)
                <tr>
                  <td>{{$salesListing->invoice_id}}</td>
                  <td>{{$salesListing->amount_paid}}</td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>
                    Total Sales
                  </th>
                  <td>

                    @foreach($totalSale as $totalSale)
                    {{$currency}}@if(!$totalSale->total_Sale)
                    0
                    @endif
                    {{$totalSale->total_Sale}}
                    @endforeach

                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <div class="col-xs-12 col-md-4">
          <!-- <p>This is a Expense.</p>   -->
          <h4>Expense</h4>
          {{getTodaysDate()}}
          <div class="panel-body" id="expense_table">
            <table class="table" id="expense-list-table">
              <thead>
                <th>Time</th>
                <th>Reason</th>
                <th>Amount</th>
              </thead>
              <tbody>
                @foreach($expenseListings as $expenseListing)
                <tr>
                  <td>{{$expenseListing->created_at->format('h:m')}}</td>
                  <td>{{$expenseListing->reason}}</td>
                  <td>{{$expenseListing->amount}}</td>
                </tr>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2">Total Expense</th>
                  <td>

                    @foreach($totalExpense as $totalExpense)
                    {{$currency}}@if(!$totalExpense->total_Expense)
                    0
                    @endif
                    {{$totalExpense->total_Expense}}
                    @endforeach

                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- end of the Modal -->
@endsection
