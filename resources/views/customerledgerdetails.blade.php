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
      <input type="hidden" name="" value="{{$customerName->customer_name}}" class="customerName"/>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>Customer Ledger</h3>
        </div>
        <div class="panel-body">
          <table class="table" id="customer-ledger-list-table">
            <thead>
              <th>Date</th>
              <th>Invoice ID</th>
              <th class="hidden-xs">Total Amount</th>
              <th class="hidden-xs">Paid Amount</th>
              <th>Due</th>
              <th>Action</th>
            </thead>
            <tbody>
              <?php $total=0; $paid=0; $due=0;?>
              @foreach($customerInfoFromDb as $customerInfo)
              <tr>
                <?php $total = $total+$customerInfo->total_amount;
                $paid = $paid + $customerInfo->paid_amount;
                $due = $due + $customerInfo->total_amount-$customerInfo->paid_amount; ?>

                <td>{{$customerInfo->created_at->format('d-m-Y')}}</td>
                <td>{{$customerInfo->id}}</td>
                <td class="hidden-xs">{{$customerInfo->total_amount}}</td>
                <td class="hidden-xs">{{$customerInfo->paid_amount}}</td>
                <td>{{$customerInfo->total_amount-$customerInfo->paid_amount}}</td>
                <td>
                  @if(($customerInfo->total_amount-$customerInfo->paid_amount)==0)
                  <span style="background-color: #2ecc71;
                  font-weight: bold;
                  font-size: 9px;
                  padding: 5px;
                  color: #fff;
                  border-radius: 3px">Paid
                </span>
                @else
                <span class="fa fa-plus-square fa-lg paymentModal"  data-toggle="modal" id="{{$customerInfo->id}}" data-total_amount="{{$customerInfo->total_amount}}" data-paid_amount="{{$customerInfo->paid_amount}}" data-customer_id="{{$customerInfo->customer_id}}" data-target="#paymentModal" style="cursor:pointer"></span>
                @endif
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
          <h3>Customer Payment History</h3>
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
            <table class="table" id="customer-ledger-history">
              <thead>
                <th>Payment Date</th>
                <th>Invoice ID</th>
                <th>Paid Amount</th>

              </thead>
              <tbody>
                @foreach($customerPayments as $customerPayment)
                <tr>
                  <td>{{$customerPayment->created_at->format('d-m-Y')}}</td>
                  <td>{{$customerPayment->invoice_id}}</td>
                  <td>{{$customerPayment->amount_paid}}</td>

                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2" style="text-align:right;">Total Amount</td>
                    <td>{{$total}}</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align:right;">Amount Paid</td>
                    <td>{{$paid}}</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align:right;">Amount Due</td>
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
            <h4 class="modal-title">Customer Payment</h4>
          </div>
          <form class="form-horizontal" role="form" method="POST" action="{{ url('updateCustomerPayment') }}">
            {{ csrf_field() }}
            <div class="modal-body">

              <div class="form-group">
                <label for="id" class="col-md-4 control-label">Invoice ID</label>
                <div class="col-md-6">
                  <input id="id" type="text" class="form-control" name="id" value="" required autofocus readonly>
                </div>
              </div>
              <div class="form-group">
                <label for="customerId" class="col-md-4 control-label">Customer ID</label>
                <div class="col-md-6">
                  <input id="customerId" type="text" class="form-control" name="customerId" value="" required autofocus readonly="">
                </div>
              </div>
              <div class="form-group">
                <label for="totalAmount" class="col-md-4 control-label">Total Amount</label>
                <div class="col-md-6">
                  <input id="totalAmount" type="text" class="form-control" name="totalAmount" value="" required autofocus readonly="">
                </div>
              </div>
              <div class="form-group">
                <label for="paidAmount" class="col-md-4 control-label">Paid Amount</label>
                <div class="col-md-6">
                  <input id="paidAmount" type="text" class="form-control" name="paidAmount" value="" required autofocus readonly="">
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
                  <input id="paymentAmount" type="number" class="form-control" name="paymentAmount" value="" required autofocus max="">
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
      var Name = $(".customerName").val();
      $('#customer-ledger-list-table').DataTable({
        "order": [[ 0, "desc" ]],
        "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
      });
      $('#customer-ledger-history').DataTable({
        "order": [[ 0, "desc" ]],
        "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
      });

      $('.pdf_btn').click(function(){
        $(".print").removeClass('hidden-xs');
        var data = $('#customer-ledger-history').html();
        var pdfName = "Customer Ledger of "+Name;
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

        $("#customer-ledger-history_length").css('display','none');
        $("#customer-ledger-history_filter").css('display','none');
        $("#customer-ledger-history_info").css('display','none');
        $("#customer-ledger-history_paginate").css('display','none');
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

        $("#customer-ledger-history_length").css('display','block');
        $("#customer-ledger-history_filter").css('display','block');
        $("#customer-ledger-history_info").css('display','block');
        $("#customer-ledger-history_paginate").css('display','block');
        $(".everyData").css('display','block');
        $(".storeClose").css('display','block');
        $(".footer").css('display','block');
        $(".companyInfo").css('display','none');
        $(".print").addClass('hidden-xs');
        $(".printHide").removeClass('hidden-xs');
        $(".printArea").html('');
      });

      $(document).on("click", ".paymentModal", function () {
        var id = $(this).attr('id');
        var customer_id = $(this).data('customer_id');
        var total_amount = $(this).data('total_amount');
        var paid_amount = $(this).data('paid_amount');
        var total_due = total_amount-paid_amount;
        $(".modal-body #id").val(id);
        $(".modal-body #id").attr("readonly","true");
        $(".modal-body #customerId").val(customer_id);
        $(".modal-body #totalAmount").val(total_amount);
        $(".modal-body #paidAmount").val(paid_amount);
        $(".modal-body #amountDue").val(total_due);
        $(".modal-body #paymentAmount").attr("max",total_due);

      });

    });


    </script>
    @endsection
