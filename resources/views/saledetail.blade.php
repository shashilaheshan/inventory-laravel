@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 everyData">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>Sales Details</h3>
          <button class="btn btn-info btn-lg pull-right actionBtn" style="margin-top:-8%;"><span class="fa fa-print fa-2x"></span></button>
          <button class="btn btn-info btn-lg pull-right pdf_btn" style="margin-top:-8%;"><span class="fa fa-download fa-2x"></span></button>
        </div>
        <div class="panel-body detailsDiv" id="sales_details">
          <div class="text-center companyInfo">
            <div class='pull-left'><span class="invoice">Invoice NO: {{$invoice->invoice_id}}</span></div>
            <div class='pull-right'><span class="date">Date: {{$invoice->created_at->format('d-m-Y')}}</span></div>
            <div class="img" style="display:inline-block;vertical-align:top; margin-top:6px;">
              <img src="/resources/assets/uploads/logo/{{getTheCompanyFavicon()}}" alt="logo not found" width="30" height="30">
            </div>
            <div class="info" style="display:inline-block;">
              <span style="font-size:30px; font-weight:bold;">{{getTheCompanyName()}}</span>
            </div><br />
            <span style="font-size:20px; font-weight:bold;">{{getTheCompanyAddress()}}</span><br />
            <span style="font-size:15px; font-weight:bold;">{{getTheCompanyPhnNo()}}</sapn>
              <div class='company_info'><h3 class="customer">Customer Name: {{$customerInfo->customer_name}}</h3></div>
              <div class='company_info'><span>Address: {{$customerInfo->address}}</span></div>

            </div>



            <table class="table" id="sale-detail-list-table">
              <thead>
                <th>Product Name</th>
                <th>Product Quantity</th>
                <th class="hidden-xs print">Percentage</th>
                <th class="hidden-xs print">Total Amount</th>
                <th>Net Price</th>
              </thead>
              <tbody>
                @foreach($saleDetails as $saleDetail)
                <tr>
                  <td>{{$saleDetail->getProductName()}}</td>
                  <td>{{$saleDetail->product_quantity}}</td>
                  <td class="hidden-xs print">{{$saleDetail->percentage}}</td>
                  <td class="hidden-xs print">{{$saleDetail->total_amount}}</td>
                  <td>{{$saleDetail->net_price}}</td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4" style="text-align:right;">Delivery Charge</td>
                  <td>{{$invoiceInfos->delivery}}</td>
                </tr>
                <tr>
                  <td colspan="4" style="text-align:right;">Total Amount</td>
                  <td>{{$invoiceInfos->total_amount}}</td>
                </tr>
                <tr>
                  <td colspan="4" style="text-align:right;">Discount</td>
                  <td>{{$invoiceInfos->reduced}}</td>
                </tr>
                <tr>
                  <td colspan="4" style="text-align:right;">Tax</td>
                  <td>{{$invoiceInfos->tax}}%</td>
                </tr>


                <tr>
                  <td colspan="4" style="text-align:right;">Paid Amount</td>
                  <td>{{$invoiceInfos->paid_amount}}</td>
                </tr>
                <tr>
                  <td colspan="4" style="text-align:right;">Amount Due</td>
                  <td>{{$invoiceInfos->total_amount-$invoiceInfos->paid_amount}}</td>
                </tr>
              </tfoot>
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
    $('#sale-detail-list-table').DataTable({
      "order": [[ 0, "desc" ]],
      "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
    });

    $('.pdf_btn').click(function(){
      $(".print").removeClass('hidden-xs');
      var invoice = $('.invoice').html();
      var date = $('.date').html();
      var customer = $('.customer').html();
      var data = $('#sale-detail-list-table').html();
      var pdfName = "Sales Details";
      $.ajaxSetup(
        {
          headers:
          {'X-CSRF-Token': $('input[name="_token"]').val()}
        });
        //alert(data);
        $.ajax({
          url:'/salepdf',
          type:'POST',
          data:{data: data, pdfName: pdfName, invoice: invoice, date: date, customer: customer},
          success:function()
          { $(".print").addClass('hidden-xs');
          window.location.href="{{url('saleprintpdf')}}";
        }
      });
    });

    $('.actionBtn').click(function(){

      $("#sale-detail-list-table_length").css('display','none');
      $("#sale-detail-list-table_filter").css('display','none');
      $("#sale-detail-list-table_info").css('display','none');
      $("#sale-detail-list-table_paginate").css('display','none');
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

      $("#sale-detail-list-table_length").css('display','block');
      $("#sale-detail-list-table_filter").css('display','block');
      $("#sale-detail-list-table_info").css('display','block');
      $("#sale-detail-list-table_paginate").css('display','block');
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
