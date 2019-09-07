@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading"><h3>Customer Ledger</h3></div>

        <div class="panel-body">
          <table class="table" id="sale-list-table">
            <thead>
              <th>Customer</th>
              <th class="hidden-xs">Customer Phone No.</th>
              <th>Total Amount</th>
              <th class="hidden-xs">Paid Amount</th>
              <th>Due</th>
              <th>Action</th>
            </thead>
            <tbody>
              @foreach($ledgerListings as $ledgerListing)
              <tr>
                <td>{{$ledgerListing->getCustomerName()}}</td>
                <td class="hidden-xs">{{$ledgerListing->getPhoneNumber()}}</td>
                <td>{{$ledgerListing->totalAmount}}</td>
                <td class="hidden-xs">{{$ledgerListing->totalPaid}}</td>
                <td>
                  @if($ledgerListing->totalAmount-$ledgerListing->totalPaid==0)
                  <span style="background-color: #2ecc71;
                  font-weight: bold;
                  font-size: 9px;
                  padding: 5px;
                  color: #fff;
                  border-radius: 3px">Paid
                </span>
                @else

                {{$ledgerListing->totalAmount-$ledgerListing->totalPaid}}

                @endif

              </td>
              <td><span class="fa fa-eye fa-lg" style="cursor:pointer" onclick="window.location.href='/customerledger/{{$ledgerListing->customer_id}}'"></span></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>


@endsection

@section('footer_scripts')
<script>
$(document).ready(function(){
  $('#sale-list-table').DataTable({
    "order": [[ 0, "desc" ]],
    "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
  });
});
</script>
@endsection
