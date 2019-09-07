@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading"><h3>Release Product</h3></div>

        <div class="panel-body">
          <table class="table" id="pending-invoice-product-list-table">
            <thead>
              <th>Product Name</th>
              <th class="hidden-xs">Quantity</th>
              <th>Pending From</th>
              <th class="hidden-xs">Pending By</th>
              <th>Action</th>
            </thead>
            <tbody>
              @foreach($pendingInvoiceProductLists as $pendingInvoiceProductList)
              <tr>
                <td>{{$pendingInvoiceProductList->book_name}}</td>
                <td class="hidden-xs">{{$pendingInvoiceProductList->book_quantity}}</td>
                <td>{{$pendingInvoiceProductList->created_at}}</td>
                <td class="hidden-xs">{{$pendingInvoiceProductList->giveMeStaffNameWhoseInvoiceIsPending()}}</td>
                <td>
                  <form role="form" method="POST" action="{{ url('releasependinginvoice') }}">
                    {{ csrf_field() }}
                    <button type="submit" name="whichTempsaleId" value="{{$pendingInvoiceProductList->id}}" title="Release">
                      <span class="fa fa-reply"></span>
                    </button>
                  </form>
                </td>
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
  $('#pending-invoice-product-list-table').DataTable({
    "order": [[ 0, "asc" ]],
    "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
  });
});
</script>
@endsection
