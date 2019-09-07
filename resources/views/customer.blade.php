@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 everyData">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>Customer List</h3>
          <button class="btn btn-info btn-lg pull-right actionBtn" ><span class="fa fa-print fa-2x"></span></button>
          <button class="btn btn-info btn-lg pull-right pdf_btn"><span class="fa fa-download fa-2x"></span></button>

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
            <table class="table" id="customer-list-table">
              <thead>
                <th class="hidden-xs print">ID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th class="hidden-xs print">Address</th>
                <th class="printHide hidden-val">Action</th>
              </thead>
              <tbody>
                @foreach($customerInfos as $customerInfo)
                <tr>
                  <td class="hidden-xs print">{{$customerInfo->id}}</td>
                  <td>{{$customerInfo->customer_name}}</td>
                  <td>{{$customerInfo->phone_number}}</td>
                  <td class="hidden-xs print">{{$customerInfo->address}}</td>
                  <td class="printHide hidden-val">
                    <span class="fa fa-close deleteConfirmation" data-toggle="modal" id="{{$customerInfo->id}}" data-customer_name="{{$customerInfo->customer_name}}" data-phone_number="{{$customerInfo->phone_number}}" data-customer_address="{{$customerInfo->address}}" data-target="#myModal2"style="cursor:pointer"></span> | <span class="fa fa-pencil customerEditModal" id="{{$customerInfo->id}}" data-customer_name="{{$customerInfo->customer_name}}" data-phone_number="{{$customerInfo->phone_number}}" data-customer_address="{{$customerInfo->address}}" style="cursor:pointer" data-toggle="modal" data-target="#myModal">
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- end-of-table -->


      <div class="col-md-4 everyData">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3>Add Customer</h3>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('addCustomer') }}">
              {{ csrf_field() }}

              <div class="form-group">
                <label for="customerName" class="col-md-4 control-label">Customer's Name</label>
                <div class="col-md-6">
                  <input id="customerName" type="text" class="form-control" name="customerName" required autofocus>
                </div>
              </div>


              <div class="form-group">
                <label for="phoneNumber" class="col-md-4 control-label">Phone Number</label>
                <div class="col-md-6">
                  <input id="phoneNumber" type="text" class="form-control" name="phoneNumber" required autofocus maxlength="11">
                </div>
              </div>

              <div class="form-group">
                <label for="address" class="col-md-4 control-label">Address</label>
                <div class="col-md-6">
                  <input id="address" type="text" class="form-control" name="address" required autofocus maxlength="11">
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

  <!-- Edit customer list modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <h4 class="modal-title">Edit Customer's Information</h4>
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('updateCustomer') }}">
          {{ csrf_field() }}
          <div class="modal-body">

            <div class="form-group" style="display:none">
              <label for="customerId" class="col-md-4 control-label">Selected ID</label>
              <div class="col-md-6">
                <input id="customerId" type="text" class="form-control" name="customerId" value="" required autofocus>
              </div>
            </div>

            <div class="form-group">
              <label for="customer_name" class="col-md-4 control-label">Customer's Name</label>
              <div class="col-md-6">
                <input id="customer_name" type="text" class="form-control" name="customer_name" required autofocus>
              </div>
            </div>

            <div class="form-group">
              <label for="phone_number" class="col-md-4 control-label">Phone Number</label>
              <div class="col-md-6">
                <input id="phone_number" type="text" class="form-control" name="phone_number" required autofocus>
              </div>
            </div>

            <div class="form-group" >
              <label for="address" class="col-md-4 control-label">Address</label>
              <div class="col-md-6">
                <input id="address" type="text" class="form-control" name="address" value="" required autofocus>
              </div>
            </div>

            <div class="modal-footer">
              <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                    Submit
                  </button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- end-of-the Edit modal -->

  <!-- deleteConfirmation of customer -->

  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Are You sure?</h4>
        </div>
        <form method="post" action="{{ url('updateCustomerSoftStatus') }}">
          <div class="modal-body">
            {{ csrf_field() }}
            <h3><span>Customer's Information</span></h3>
            <label for="name">Name :</label> <span id="name"></span><br />
            <label for="phnNo">Phone Number :</label> <span id="phnNo"></span><br />
            <label for="address">Address :</label> <span id="address"></span><br />
            <input type="hidden" name="softStatus" value="2" />
            <input type="hidden"  name="softID" id="softID" value="" />
          </div>
          <div class="modal-footer">
            <div class="form-group">
              <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-success">
                  Confirm
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- end-of-soft-delete-conformation -->
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
    $('#customer-list-table').DataTable({
      "order": [[ 0, "desc" ]],
      "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
    });

    $(document).on("click", ".customerEditModal", function () {
      var customerId = $(this).attr('id');
      var customer_name= $(this).data('customer_name');
      var phone_number= $(this).data('phone_number');
      var customer_address= $(this).data('customer_address');

      $(".modal-body #customerId").val(customerId);
      $(".modal-body #customer_name").val(customer_name);
      $(".modal-body #phone_number").val(phone_number);
      $(".modal-body #address").val(customer_address);
    });

    $(document).on("click", ".deleteConfirmation", function () {
      var customerId = $(this).attr('id');
      var customer_name= $(this).data('customer_name');
      var phone_number= $(this).data('phone_number');
      var customer_address= $(this).data('customer_address');
      $(".modal-body #softID").val(customerId);
      $(".modal-body #name").html(customer_name);
      $(".modal-body #phnNo").html(phone_number);
      $(".modal-body #address").html(customer_address);
    });

    $('.actionBtn').click(function(){

      $("#customer-list-table_length").css('display','none');
      $("#customer-list-table_filter").css('display','none');
      $("#customer-list-table_info").css('display','none');
      $("#customer-list-table_paginate").css('display','none');
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

      $("#customer-list-table_length").css('display','block');
      $("#customer-list-table_filter").css('display','block');
      $("#customer-list-table_info").css('display','block');
      $("#customer-list-table_paginate").css('display','block');
      $(".everyData").css('display','block');
      $(".storeClose").css('display','block');
      $(".footer").css('display','block');
      $(".companyInfo").css('display','none');
      $(".print").addClass('hidden-xs');
      $(".printHide").removeClass('hidden-xs');
      $(".printArea").html('');
    });

    $('.pdf_btn').click(function(){
      $(".print").removeClass('hidden-xs');
      var data = $('#customer-list-table').html();
      var pdfName = "Customers List";
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
  });
  </script>
  @endsection
