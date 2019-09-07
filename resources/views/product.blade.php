@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 everyData">
      <div class="panel panel-primary">
        <div class="panel-heading"><h3>Products</h3>
          <button class="btn btn-info btn-lg pull-right actionBtn" id="actionBtn"><span class="fa fa-print fa-2x"></span></button>
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

            <table class="table" id="product-list-table">
              <thead>
                <th class="hidden-xs print hidden-val">ID</th>
                <th class="hidden-xs print">Product Name</th>
                <th>Product Code</th>
                <th>Supplier Name</th>
                <th class="hidden-xs print">Category</th>
                <th class="hidden-xs print">Quantity</th>
                <th class="hidden-xs print">Alert Quantity</th>
                <th>Selling Price({{getTheCurrency()}})</th>
              </thead>
              <tbody>
                @foreach($productLists as $productList)
                <?php
                $vendorDeleteStatus = \App\Vendor::selectRaw('soft_delete')->where('id',$productList->vendor_id)->get();
                foreach ($vendorDeleteStatus as $vendorDeleteStatu) {
                  if($vendorDeleteStatu->soft_delete!=2){
                    ?>
                    <tr class="tableData" data-toggle="modal" data-target="#changeAlertQuantity" style="cursor:pointer" title="Change Alert Quentity">
                      <td class="hidden-xs print hidden-val">{{$productList->id}}</td>
                      <td class="hidden-xs print">{{$productList->product_name}}</td>
                      <td class="product_name">{{$productList->product_code}}</td>
                      <td>{{$productList->giveMeVendorName()}}</td>
                      <td class="hidden-xs print">{{$productList->categoryName()}}</td>
                      <td class="hidden-xs print" >{{$productList->inventorie->quantity}}</td>
                      <td class="alertQ hidden-xs print">{{$productList->inventorie->alert_quantity}}</td>
                      <td class="unit_price">{{$productList->inventorie->unit_price}}</td>
                    </tr>
                    <?php
                  }
                }
                ?>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4 addProduct everyData">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3> Add Product</h3>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('addProduct') }}">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="vendorName" class="col-md-4 control-label">Supplier Name</label>
                <div class="col-md-6">
                  <select id="vendorName" class="form-control" name="vendorName" required="">
                    <option value="">-Select-</option>
                    @foreach($vendorNames as $vendorName)
                    <option value="{{$vendorName->id}}">{{$vendorName->vendor_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="productName" class="col-md-4 control-label">Product Name</label>
                <div class="col-md-6">
                  <input id="productName" type="text" class="form-control" name="productName" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label for="productCode" class="col-md-4 control-label">Product Code</label>
                <div class="col-md-6">
                  <input id="productCode" type="text" class="form-control" name="productCode" autofocus>
                </div>
              </div>
              <div class="form-group">
                <label for="category" class="col-md-4 control-label">Category</label>
                <div class="col-md-6">
                  <select class="form-control" name="category">
                    <option value="">-Select-</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="price" class="col-md-4 control-label">Selling Price</label>
                <div class="col-md-6">
                  <input id="price" type="text" class="form-control" name="price" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label for="percentage" class="col-md-4 control-label">Percentage %</label>
                <div class="col-md-6">
                  <input id="percentage" type="text" class="form-control" name="percentage"  required autofocus>
                </div>

              </div>
              <div class="form-group">
                <label for="alertQuantity" class="col-md-4 control-label">Alert Quantity</label>
                <div class="col-md-6">
                  <input id="alertQuantity" type="text" class="form-control" name="alertQuantity" required autofocus>
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
    <!-- 1h1h1h1 -->
    <div class="modal fade" id="changeAlertQuantity" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Change Alert Quantity & Unit Price
          </div>
          <div class="modal-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('changeAlertQuanityAndUnitPrice') }}">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="name" class="col-md-4 control-label">Product ID</label>
                <div class="col-md-6">
                  <input id="name" type="text" class="form-control" name="product_name" readonly="">
                </div>
              </div>
              <div class="form-group">
                <label for="alert_quantity" class="col-md-4 control-label">Alert Quantity</label>
                <div class="col-md-6">
                  <input id="alert_quantity" type="text" class="form-control" name="alert_quantity" required="">
                </div>
              </div>
              <div class="form-group">
                <label for="unit_price" class="col-md-4 control-label">Unit Price</label>
                <div class="col-md-6">
                  <input id="unit_price" type="text" class="form-control" name="unit_price" required="">
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
    </div>
    <!-- 1h1h1h1 -->
  </div>
</div>

@endsection

@section('footer_scripts')
<style media="screen">
.actionBtn,.pdf_btn{
  margin-top: -56px;
}

.companyInfo{
  display: none;
}

</style>
<script>
$(document).ready(function(){
  $('#product-list-table').DataTable({
    "order": [[ 0, "desc" ]],
    "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
  });

  $(".tableData").click(function(){
    var name = $(this).children('td:first').html();
    var alert_quantity = $(this).closest('tr').children('td.alertQ').html();
    var unit_price = $(this).closest('tr').children('td.unit_price').html();
    $("#name").val(name);
    $("#alert_quantity").val(alert_quantity);
    $("#unit_price").val(unit_price);
  });

  $('.pdf_btn').click(function(){
    $(".print").removeClass('hidden-xs');
    var data = $('#product-list-table').html();
    var pdfName = "Products";

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

    $("#product-list-table_length").css('display','none');
    $("#product-list-table_filter").css('display','none');
    $("#product-list-table_info").css('display','none');
    $("#product-list-table_paginate").css('display','none');
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

    $("#product-list-table_length").css('display','block');
    $("#product-list-table_filter").css('display','block');
    $("#product-list-table_info").css('display','block');
    $("#product-list-table_paginate").css('display','block');
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
