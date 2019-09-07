@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 everyData">
      @if (Session::has('paymentamountadded'))
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('paymentamountadded') }}
      </div>
      @endif
      <input type="hidden" name="" value="{{$vendorName->vendor_name}}" class="vendorName">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>Suppliers Details of {{$vendorName->vendor_name}}</h3>
        </div>
        <div class="panel-body">


          <table class="table" id="vendor-list-table">
            <thead>
              <th>Invoice ID</th>
              <th class="hidden-xs print">Total Purchase</th>
              <th class="hidden-xs print">Total Amount</th>
              <th>Due</th>
              <th>Payment</th>
            </thead>
            <?php $total=0; $paid=0; $due=0;?>

            <tbody>
              @foreach($vendorInfoFromDb as $vendorInfo)
              <tr>
                <?php $total = $total + $vendorInfo->total_purchase;
                $paid = $paid + $vendorInfo->amount_paid;
                $due = $due + $vendorInfo->total_purchase-$vendorInfo->amount_paid; ?>
                <td>{{$vendorInfo->invoice_id}}</td>
                <td class="hidden-xs print">{{$vendorInfo->total_purchase}}</td>
                <td class="hidden-xs print">{{$vendorInfo->amount_paid}}</td>
                <td>{{$vendorInfo->total_purchase-$vendorInfo->amount_paid}}</td>
                <td>
                  @if(($vendorInfo->total_purchase-$vendorInfo->amount_paid) == 0)
                  <span style="background-color: #2ecc71;
                  font-weight: bold;
                  font-size: 9px;
                  padding: 5px;
                  color: #fff;
                  border-radius: 3px">Paid
                </span>
                @else
                <span class="fa fa-plus-square fa-lg paymentModal" data-toggle="modal" id="{{$vendorInfo->vendor_id}}" data-total_purchase="{{$vendorInfo->total_purchase}}" data-amount_paid="{{$vendorInfo->amount_paid}}" data-invoice_id="{{$vendorInfo->invoice_id}}" data-target="#paymentModal" style="cursor:pointer" title="Payment"></span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-8 col-md-offset-2 everyData">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3>Payment History</h3>
        <button class="btn btn-info btn-lg pull-right actionBtn" style="margin-top:-49px;"><span class="fa fa-print fa-2x"></span></button>
        <button class="btn btn-info btn-lg pull-right pdf_btn" style="margin-top:-49px;"><span class="fa fa-download fa-2x"></span></button>
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
          <table class="table" id="vendor-payment">
            <thead>
              <th>Payment Date</th>
              <th>Invoice ID</th>
              <th class="hidden-xs print">From Where</th>
              <th>Paid Amount</th>
            </thead>
            <tbody>
              @foreach($vendorPayments as $vendorPayment)
              <tr>
                <td>{{$vendorPayment->created_at->format('d-m-Y')}}</td>
                <td>{{$vendorPayment->invoice_id}}</td>
                <td class="hidden-xs print">@if($vendorPayment->from_where == 1)
                  From Cash
                  @else
                  From Hand
                  @endif
                </td>
                <td>{{$vendorPayment->amount_paid}}</td>


                @endforeach
              </tbody>
              <tfoot >
                <tr>
                  <td colspan="3" style="text-align:right;">Total Amount</td>
                  <td>{{$total}}</td>
                </tr>
                <tr>
                  <td colspan="3" style="text-align:right;">Amount Paid</td>
                  <td>{{$paid}}</td>
                </tr>
                <tr>
                  <td colspan="3" style="text-align:right;">Amount Due</td>
                  <td>{{$due}}</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <div class="printArea"></div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="paymentModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Payment</h4>
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('updateVendorPayment') }}">
          {{ csrf_field() }}
          <div class="modal-body">
            <div class="form-group">
              <label for="id" class="col-md-4 control-label">Suppliers ID</label>
              <div class="col-md-6">
                <input id="id" type="text" class="form-control" name="vendor_id" value="" required autofocus readonly="">
              </div>
            </div>
            <div class="form-group">
              <label for="invoiceId" class="col-md-4 control-label">Invoice ID</label>
              <div class="col-md-6">
                <input id="invoiceId" type="text" class="form-control" name="invoiceId" value="" required autofocus readonly="">
              </div>
            </div>
            <div class="form-group">
              <label for="totalPurchase" class="col-md-4 control-label">Total Purchase</label>
              <div class="col-md-6">
                <input id="totalPurchase" type="text" class="form-control" name="totalPurchase" value="" required autofocus readonly="">
              </div>
            </div>
            <div class="form-group">
              <label for="amountPaid" class="col-md-4 control-label">Amount Paid</label>
              <div class="col-md-6">
                <input id="amountPaid" type="text" class="form-control" name="amountPaid" value="" required autofocus readonly="">
              </div>
            </div>
            <div class="form-group">
              <label for="amountDue" class="col-md-4 control-label">Due Amount</label>
              <div class="col-md-6">
                <input id="amountDue" type="text" class="form-control" name="amountDue" value="" required autofocus readonly="">
              </div>
            </div>
            <div class="form-group">
              <label for="paymentAmount" class="col-md-4 control-label">Amount Payment</label>
              <div class="col-md-6">
                <select class="form-control" name="fromWhere" required="" id="where">
                  <option value="">-select-</option>
                  <option value="1">From Cash</option>
                  <option value="2">From Hand</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="paymentAmount" class="col-md-4 control-label">Amount Payment</label>
              <div class="col-md-6">

                <input id="paymentAmount" type="number" class="form-control" name="paymentAmount" value="" required autofocus max="">
                <span> In Cash Money: <span class="cash">{{getTotalEarningOfToday()-getTotalExpenseOfToday()}}</span></span>
              </div>
            </div>


            <div class="modal-footer">
              <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                  <button type="submit" class="btn btn-primary submit">
                    Submit
                  </button>
                  <button type="button " class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- end modal -->
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
    var name = $(".vendorName").val();

    $('#vendor-list-table').DataTable({
      "order": [[ 3, "desc" ]],
      "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
    });
    $('#vendor-payment').DataTable({
      "order": [[ 0, "desc" ]],
      "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
    });

    $(document).on("click", ".paymentModal", function () {
      var id = $(this).attr('id');
      var invoice_id = $(this).data('invoice_id');
      var total_purchase = $(this).data('total_purchase');
      var amount_paid = $(this).data('amount_paid');
      var total_due = total_purchase-amount_paid;
      $(".modal-body #id").val(id);
      $(".modal-body #id").attr("readonly","true");
      $(".modal-body #invoiceId").val(invoice_id);
      $(".modal-body #totalPurchase").val(total_purchase);
      $(".modal-body #amountPaid").val(amount_paid);
      $(".modal-body #amountDue").val(total_due);
      $(".modal-body #paymentAmount").attr("max",total_due);

    });
    $('#paymentAmount').on('keyup',function(){
      var cash = parseInt($('.cash').html());
      if($("#where").val() == 1)
      {
        if($(this).val() - cash > 0)
        {
          alert("You don't have enough cash");
          $(".submit").attr('disabled',true);
        }
        else {
          $(".submit").attr('disabled',false);
        }
      }
    });

    $('#where').on('change',function(){

      var select = $(this).val();
      var cash = parseInt($('.cash').html());

      if(select == 1)
      {
        if($("#paymentAmount").val() - cash > 0)
        {
          alert("you don't have enough cash");
          $(".submit").attr('disabled',true);
        }
        else {
          $(".submit").attr('disabled',false);
        }
      }
      else
      {
        $(".submit").attr('disabled',false);
      }
    });
    $('.pdf_btn').click(function(){
      $(".print").removeClass('hidden-xs');

      var data = $('#vendor-payment').html();
      var pdfName = "Ledger Of "+name;
      $.ajaxSetup(
        {
          headers:
          {'X-CSRF-Token': $('input[name="_token"]').val()}
        });
        //alert(data);
        $.ajax({
          url:'/expensepdf',
          type:'POST',
          data:{data: data, pdfName: pdfName},
          success:function()
          {   $(".print").addClass('hidden-xs');
          window.location.href="{{url('printpdf')}}";
        }
      });
    });

    $('.actionBtn').click(function(){

      $("#vendor-payment_length").css('display','none');
      $("#vendor-payment_filter").css('display','none');
      $("#vendor-payment_info").css('display','none');
      $("#vendor-payment_paginate").css('display','none');
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

      $("#vendor-payment_length").css('display','block');
      $("#vendor-payment_filter").css('display','block');
      $("#vendor-payment_info").css('display','block');
      $("#vendor-payment_paginate").css('display','block');
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
