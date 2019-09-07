@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 everyData">
      <div class="panel panel-primary">
        <div class="panel-heading"><h3>Alert</h3>
          <button class="btn btn-info btn-lg pull-right actionBtn"><span class="fa fa-print fa-2x"></span></button>
          <button class="btn btn-info btn-lg pull-right pdf_btn"><span class="fa fa-download fa-2x"></span></button>
        </div>
        <div class="panel-body detailsDiv" id="alert_table">
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

            <table class="table" id="alert-list-table">
              <div class="logo hidden">
                <img class="logo"  src="/resources/assets/uploads/logo/{{ $companyInfo->logo }}" width="100" height="100" />
              </div>
              <div class="company_info hidden">
                <h1 class="text-center companyName" >{{$companyInfo->company_name}}</h1>
                <h5 class="text-center">Address: {{$companyInfo->address}}</h5>
                <h6 class="text-center">Phone Number: {{$companyInfo->phone_number}}</h6>
              </div>
              <div class='company_info hidden'><h1>Alert List</h1></div>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <thead>
                <th>Product Name</th>
                <th>Supplier Name</th>
                <th class="hidden-xs print">Category</th>
                <th>We Have</th>
                <th class="hidden-xs">Alert</th>

              </thead>
              <tbody>
                @foreach($alertLists as $alertList)
                <tr>
                  <td>{{$alertList->product->product_name}}</td>
                  <td>{{$alertList->product->giveMeVendorName()}}</td>
                  <td class="hidden-xs print">{{$alertList->product->categoryName()}}</td>
                  <td >{{$alertList->quantity}}</td>
                  <td class="hidden-xs">{{$alertList->alert_quantity}}</td>
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
    $('#alert-list-table').DataTable({
      "order": [[ 0, "desc" ]],
      "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
    });

    $('.pdf_btn').click(function(){
      var data = $('#alert-list-table').html();
      var pdfName = "Alert Products";
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
          {
            window.location.href="{{url('printpdf')}}";
          }
        });
      });

      $('.actionBtn').click(function(){

        $("#alert-list-table_length").css('display','none');
        $("#alert-list-table_filter").css('display','none');
        $("#alert-list-table_info").css('display','none');
        $("#alert-list-table_paginate").css('display','none');
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

        $("#alert-list-table_length").css('display','block');
        $("#alert-list-table_filter").css('display','block');
        $("#alert-list-table_info").css('display','block');
        $("#alert-list-table_paginate").css('display','block');
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
