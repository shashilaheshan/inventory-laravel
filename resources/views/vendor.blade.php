@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 everyData">
      <div class="panel panel-primary">
        <div class="panel-heading"><h3>Suppliers List</h3>
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
            <table class="table" id="vendor-list-table">

              <thead>
                <th class="hidden-xs print">ID</th>
                <th>Suppliers Name</th>
                <th>Phone Number</th>
                <th class="hidden-xs print">Email Address</th>
                <th class="hidden-xs print">Address</th>
                <th class="printHide hidden-val">Action</th>
              </thead>
              <tbody>
                @foreach($vendorListings as $vendorListing)
                <tr>
                  <td class="hidden-xs print">{{$vendorListing->id}}</td>
                  <td>{{$vendorListing->vendor_name}}</td>
                  <td>{{$vendorListing->phone_number}}</td>
                  <td class="hidden-xs print">{{$vendorListing->email_address}}</td>
                  <td class="hidden-xs print">{{$vendorListing->address}}</td>
                  <td class="printHide hidden-val"><span class="fa fa-close deleteConfirmation" data-toggle="modal" id="{{$vendorListing->id}}" data-vendor_name="{{$vendorListing->vendor_name}}" data-phone_number="{{$vendorListing->phone_number}}" data-vendor_address="{{$vendorListing->address}}" data-vendor_emailaddress="{{$vendorListing->email_address}}" data-target="#myModal2"style="cursor:pointer"></span> | <span class="fa fa-pencil editModal" id="{{$vendorListing->id}}" data-vendor_name="{{$vendorListing->vendor_name}}" data-phone_number="{{$vendorListing->phone_number}}" data-vendor_address="{{$vendorListing->address}}" data-vendor_emailaddress="{{$vendorListing->email_address}}" style="cursor:pointer" data-toggle="modal" data-target="#myModal"></span></td>
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
            <h3>Add Suppliers</h3>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('addVendor') }}">
              {{ csrf_field() }}

              <div class="form-group">
                <label for="name" class="col-md-4 control-label">Supplier's Name</label>
                <div class="col-md-6">
                  <input id="name" type="text" class="form-control" name="name" required autofocus>
                </div>
              </div>

              <div class="form-group">
                <label for="phoneNo" class="col-md-4 control-label">Phone Number</label>
                <div class="col-md-6">
                  <input id="phoneNo" type="text" class="form-control" name="phoneNo" required autofocus maxlength="11">
                </div>
              </div>


              <div class="form-group">
                <label for="emailAddress" class="col-md-4 control-label">Email Address</label>
                <div class="col-md-6">
                  <input id="emailAddress" type="email" class="form-control" name="emailAddress" autofocus>
                </div>
              </div>

              <div class="form-group">
                <label for="address" class="col-md-4 control-label">Address</label>
                <div class="col-md-6">
                  <input id="address" type="text" class="form-control" name="address" required autofocus>
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
  <!-- Edit-Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <form class="form-horizontal" role="form" method="POST" action="{{ url('updateVendor') }}">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Supplier's Information</h4>
          </div>
          <div class="modal-body">
            {{ csrf_field() }}
            <div class="form-group" style="display:none">
              <label for="id" class="col-md-4 control-label">Selected ID</label>
              <div class="col-md-6">
                <input id="id" type="text" class="form-control" name="id" value="" required autofocus>
              </div>
            </div>
            <div class="form-group">
              <label for="editName" class="col-md-4 control-label">Supplier's Name</label>
              <div class="col-md-6">
                <input id="editName" type="text" class="form-control" name="editName" required autofocus>
              </div>
            </div>

            <div class="form-group">
              <label for="editPhoneNo" class="col-md-4 control-label">Phone Number</label>
              <div class="col-md-6">
                <input id="editPhoneNo" type="text" class="form-control" name="editPhoneNo" required autofocus>
              </div>
            </div>

            <div class="form-group">
              <label for="editAddress" class="col-md-4 control-label">Address</label>
              <div class="col-md-6">
                <input id="editAddress" type="text" class="form-control" name="editAddress" required autofocus>
              </div>
            </div>

            <div class="form-group">
              <label for="editEmailAddress" class="col-md-4 control-label">Email Address</label>
              <div class="col-md-6">
                <input id="editEmailAddress" type="email" class="form-control" name="editEmailAddress" autofocus>
              </div>
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
  <!-- end-of edit-Modal -->
  <!-- soft-delete-conformation -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Are You sure?</h4>
        </div>
        <form method="post" action="{{ url('updateSoftStatus') }}">
          <div class="modal-body">
            {{ csrf_field() }}
            <h3><span>Supplier Information</span></h3>
            <label for="name">Name :</label> <span id="name"></span><br />
            <label for="phnNo">Phone Number :</label> <span id="phnNo"></span><br />
            <label for="address">Address :</label> <span id="address"></span><br />
            <label for="emailaddress">Email Address :</label> <span id="emailaddress"></span><br />
            <input type="hidden" name="softStatus" value="2"/>
            <input type="hidden"  name="softID" id="softID" value=""/>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">
              Confirm
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- end-of-soft-delete-conformation -->

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
    $('#vendor-list-table').DataTable({
      "order": [[ 0, "desc" ]],
      "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
    });

    $(document).on("click", ".editModal", function () {
      var vendorId = $(this).attr('id');
      var vendor_name= $(this).data('vendor_name');
      var phone_number= $(this).data('phone_number');
      var vendor_address= $(this).data('vendor_address');
      var vendor_emailaddress= $(this).data('vendor_emailaddress');
      $(".modal-body #id").val(vendorId);
      $(".modal-body #editName").val(vendor_name);
      $(".modal-body #editPhoneNo").val(phone_number);
      $(".modal-body #editAddress").val(vendor_address);
      $(".modal-body #editEmailAddress").val(vendor_emailaddress);

    });
    $(document).on("click", ".deleteConfirmation", function () {
      var vendorId = $(this).attr('id');
      var vendor_name= $(this).data('vendor_name');
      var phone_number= $(this).data('phone_number');
      var vendor_address= $(this).data('vendor_address');
      var vendor_emailaddress= $(this).data('vendor_emailaddress');
      $(".modal-body #softID").val(vendorId);
      $(".modal-body #name").html(vendor_name);
      $(".modal-body #phnNo").html(phone_number);
      $(".modal-body #address").html(vendor_address);
      $(".modal-body #emailaddress").html(vendor_emailaddress);


    });
    $('.pdf_btn').click(function(){
      $(".print").removeClass('hidden-xs');
      var data = $('#vendor-list-table').html();
      var pdfName = "Suppliers List";
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

      $("#vendor-list-table_length").css('display','none');
      $("#vendor-list-table_filter").css('display','none');
      $("#vendor-list-table_info").css('display','none');
      $("#vendor-list-table_paginate").css('display','none');
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

      $("#vendor-list-table_length").css('display','block');
      $("#vendor-list-table_filter").css('display','block');
      $("#vendor-list-table_info").css('display','block');
      $("#vendor-list-table_paginate").css('display','block');
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
