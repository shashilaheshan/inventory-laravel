@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 everyData">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>Damages</h3>
          <button class="btn btn-info btn-lg pull-right actionBtn"><span class="fa fa-print fa-2x"></span></button>
          <button class="btn btn-info btn-lg pull-right pdf_btn"><span class="fa fa-download fa-2x"></span></button>
        </div>
        <div class="panel-body detailsDiv" id="damage_table">
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

            <table class="table" id="damage-list-table">
              <thead>
                <th>Date</th>
                <th>Product Name</th>
                <th class="hidden-xs">Quantity</th>
                <th>Reason</th>
                <th class="hidden-xs ">Issued By</th>
              </thead>
              <tbody>
                @foreach($damageListings as $damageListing)
                <tr>
                  <td>{{$damageListing->created_at->format("d-m-Y")}}</td>
                  <td>{{$damageListing->productName()}}</td>
                  <td class="hidden-xs ">{{$damageListing->quantity}}</td>
                  <td>{{$damageListing->reason}}</td>
                  <td class="hidden-xs ">{{$damageListing->issued_by}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-4 everyData">

        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3>Add Damage Quantity</h3>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('damageissue') }}">
              {{ csrf_field() }}

              <div class="form-group">
                <label for="product_name" class="col-md-4 control-label">Product Name</label>
                <div class="col-md-6">
                  <select id="product_name" class="form-control" name="product_name" required="">
                    <option value="">-Select-</option>
                    @foreach($productLists as $productList)
                    <option value="{{$productList->product_id}}">{{$productList->product->product_name}}-{{$productList->product->product_code}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="quantity" class="col-md-4 control-label">Quantity</label>
                <div class="col-md-6">
                  <input id="quantity" type="number" class="form-control" name="quantity" min='1' required autofocus>
                </div>
              </div>


              <div class="form-group">
                <label for="reason" class="col-md-4 control-label">Reason</label>
                <div class="col-md-6">
                  <input id="reason" type="text" class="form-control" name="reason" required autofocus>
                </div>
              </div>


              <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                    Submit
                  </button>
                </div>
              </div>
            </form>
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
    $("#product_name").select2();
    $('#damage-list-table').DataTable({
      "order": [[ 0, "desc" ]],
      "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
    });

    $("#product_name").on('change',function(){
      var product_id = $(this).val();

      $.ajaxSetup(
        {
          headers:
          {'X-CSRF-Token': $('input[name="_token"]').val()}
        });

        $.ajax({
          url:'./damagelist',
          type:'POST',
          data:{product_id: product_id},
          success: function (data) {
            $("#quantity").attr("max",data);
          }

        });
      });

      $('.pdf_btn').click(function(){
        var data = $('#damage-list-table').html();
        var pdfName = "Damage Lists";
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

          $("#damage-list-table_length").css('display','none');
          $("#damage-list-table_filter").css('display','none');
          $("#damage-list-table_info").css('display','none');
          $("#damage-list-table_paginate").css('display','none');
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

          $("#damage-list-table_length").css('display','block');
          $("#damage-list-table_filter").css('display','block');
          $("#damage-list-table_info").css('display','block');
          $("#damage-list-table_paginate").css('display','block');
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
