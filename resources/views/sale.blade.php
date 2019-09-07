@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12 everyData">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>Sales List</h3>
          <button class="btn btn-info btn-lg pull-right actionBtn"><span class="fa fa-print fa-2x"></span></button>
          <button class="btn btn-info btn-lg pull-right pdf_btn" ><span class="fa fa-download fa-2x"></span></button>
        </div>

        <div class="panel-body detailsDiv">
          <div class="text-center companyInfo">
            <div class="img" style="display:inline-block;vertical-align:top; margin-top:6px;">
              <img src="/resources/assets/uploads/logo/{{getTheCompanyFavicon()}}" alt="logo not found" width="30" height="30">
            </div>
            <div class="info" style="display:inline-block;">
              <span style="font-size:30px; font-weight:bold;">{{getTheCompanyName()}}</span>
            </div><br />
            <span style="font-size:20px; font-weight:bold;">{{getTheCompanyAddress()}}</span><br />
            <span style="font-size:15px; font-weight:bold;">{{getTheCompanyPhnNo()}}</sapn>

            </div>

            <table class="table" id="sale-list-table">
              <thead>
                <th class="hidden-xs print">Invoice ID</th>
                <th> Name</th>
                <th class="hidden-xs print hidden-val"> Quantity</th>
                <th class="hidden-xs"> Amount</th>
                <th class="hidden-xs print">Paid Amount</th>
                <th class="hidden-xs print">Amount Due</th>
                <th class="hidden-val">Status</th>
                <th class="hidden-xs print">Serve At</th>
                <th class="printHide hidden-val">Action</th>
              </thead>
              <tbody>
                @foreach($salesListings as $salesListing)
                <tr>
                  <td class="hidden-xs print">{{$salesListing->id}}</td>
                  <td>{{$salesListing->getCustomerName()}}</td>
                  <td class="hidden-xs print hidden-val">{{$salesListing->total_quantity}}</td>
                  <td class="hidden-xs">{{$salesListing->total_amount}}</td>
                  <td class="hidden-xs print">{{$salesListing->paid_amount}}</td>
                  <td class="hidden-xs print">{{$salesListing->total_amount-$salesListing->paid_amount}}</td>
                  <td class="hidden-val">@if($salesListing->total_amount == $salesListing->paid_amount)
                    <span style="background-color: #2ecc71;
                    font-weight: bold;
                    font-size: 9px;
                    padding: 5px;
                    color: #fff;
                    border-radius: 3px">Paid
                  </span>
                  @endif
                  @if($salesListing->paid_amount > 0 && $salesListing->paid_amount < $salesListing->total_amount)
                  <span style="background-color: #FFB950;
                  font-weight: bold;
                  font-size: 9px;
                  padding: 5px;
                  color: #fff;
                  border-radius: 3px">Partial
                </span>
                @endif
                @if($salesListing->paid_amount == 0)
                <span style="background-color: #DD5454;
                font-weight: bold;
                font-size: 9px;
                padding: 5px;
                color: #fff;
                border-radius: 3px">Unpaid
              </span>
              @endif
            </td>
            <td class="hidden-xs print">{{$salesListing->created_at}}</td>
            <td class="printHide hidden-val"><span class="fa fa-eye fa-lg"  style="cursor:pointer" title="Details" onclick="window.location.href='/sale/{{$salesListing->id}}'"></span></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="printArea"></div>
</div>
</div>


@endsection

@section('footer_scripts')
<style media="screen">
.companyInfo{
  display: none;
}
.actionBtn,.pdf_btn{
  margin-top: -56px;
}

</style>
<script>
$(document).ready(function(){
  $('#sale-list-table').DataTable({
    "order": [[ 0, "desc" ]],
    "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
  });

  $('.pdf_btn').click(function(){
    $(".print").removeClass('hidden-xs');
    var data = $('#sale-list-table').html();
    var pdfName = "Sales List";
    $.ajaxSetup(
      {
        headers:
        {'X-CSRF-Token': $('input[name="_token"]').val()}
      });
      //alert(data);
      $.ajax({
        url:'./expensepdf',
        type:'POST',
        data:{data: data, pdfName: pdfName},
        success:function()
        {   $(".print").addClass('hidden-xs');
        window.location.href="{{url('printpdf')}}";
      }
    });
  });

  $('.actionBtn').click(function(){

    $("#sale-list-table_length").css('display','none');
    $("#sale-list-table_filter").css('display','none');
    $("#sale-list-table_info").css('display','none');
    $("#sale-list-table_paginate").css('display','none');
    $(".companyInfo").css('display','block');
    $(".companyInfo").css('margin-bottom','35px');
    //if any hidden-xs is in the table
    $(".print").removeClass('hidden-xs');
    $(".printHide").addClass('hidden-xs');
    var action = $('.detailsDiv').html();
    $('.printArea').html(action);
    $(".everyData").css('display','none');
    $(".storeClose").css('display','none');
    $(".footer").css('display','none');
    $(".printArea").append('<style>body{margin: 10mm 15mm 10mm 15mm;} @page{size:auto; margin: 0mm}</style>');
    $(".printArea").css('display','block');

    window.print();

    $("#sale-list-table_length").css('display','block');
    $("#sale-list-table_filter").css('display','block');
    $("#sale-list-table_info").css('display','block');
    $("#sale-list-table_paginate").css('display','block');
    $(".everyData").css('display','block');
    $(".storeClose").css('display','block');
    $(".footer").css('display','block');
    $(".companyInfo").css('display','none');
    $(".print").addClass('hidden-xs');
    $(".printHide").removeClass('hidden-xs');
    $(".printArea").html('');
  });

});
</script>
@endsection
