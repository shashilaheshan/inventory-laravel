@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3> Supplier's Ledger</h3>
        </div>
        <div class="panel-body">
          <table class="table" id="vendor-list-table">
            <thead>
              <th>Supplier</th>
              <th class="hidden-xs">Total Sale</th>
              <th class="hidden-xs">Total Paid</th>
              <th>Due</th>
              <th>Action</th>
            </thead>
            <tbody>
              @foreach($vendorsTransections as $vendorsTransection)
              <tr>
                <td>{{$vendorsTransection->getVendorName()}}</td>
                <td class="hidden-xs">{{$vendorsTransection->purchase_sum}}</td>
                <td class="hidden-xs">{{$vendorsTransection->paid_sum}}</td>
                <td>
                  @if($vendorsTransection->purchase_sum-$vendorsTransection->paid_sum==0)
                  <span style="background-color: #2ecc71;
                  font-weight: bold;
                  font-size: 9px;
                  padding: 5px;
                  color: #fff;
                  border-radius: 3px">Paid
                </span>
                @else
                {{$vendorsTransection->purchase_sum-$vendorsTransection->paid_sum}}
                @endif
              </td>
              <td><span class="fa fa-eye fa-lg" style="cursor:pointer" onclick="window.location.href='/vendorledger/{{$vendorsTransection->vendor_id}}'"></span></td>
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
  $('#vendor-list-table').DataTable({
    "order": [[ 0, "desc" ]],
    "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
  });
});
</script>
@endsection
