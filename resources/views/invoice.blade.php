@extends('layouts.app')

@section('content')
<div class="container" id="invoiceSystem">
  <div class="row generate_invoice">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>Generate Invoice</h3>
          <button type="button" name="deletepos" class="btn btn-danger deletepos pull-right" style="margin-top:-5%"><span class="fa fa-trash-o fa-3x " title="Delete Invoice"></span></button>
        </div>
        <div class="panel-body">
          <section class="text-center row" >
            @if(isset($customerInfo))
            <h2>Your Invoice is On going</h2>
            @else
            <span style="font-weight:bold; font-size:20px;">Select Customer</span>
            <select class="customer" name="customer" style="width:40%;">
              <option value="">-Select Customer-</option>
              @foreach($customerLists as $customerList)
              <option value="{{$customerList->id}}">{{$customerList->customer_name}} - {{$customerList->phone_number}}</option>
              @endforeach
            </select>
            <span class="fa fa-user-plus" title="Add Customer" data-toggle="modal" data-target="#customerAddModal" style="cursor:pointer"></span>
            @endif

          </section>

          <!-- modal of cusomer add -->
          <div class="modal fade" id="customerAddModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  Add Customer
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" role="form" method="POST" action="{{ url('addCustomerFromInvoice') }}">
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
          </div>
          <!-- modal of cusomer add-end -->

          <form class="form-horizontal" role="form" method="POST">
            {{ csrf_field() }}
            <table class="table table-striped invoice_table">
              <thead>
                <tr>
                  <th style="width:40%">Product Name</th>
                  <th>Available</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Total Price</th>
                  <th>Percentage</th>
                  <th>Net Price</th>
                </tr>
              </thead>
              <tbody>
                <tr><div class="form-group">
                  <td><select id="bookName" type="text" name="bookName[]" class="form-control" required autofocus>
                    <option>-Select Product-</option>
                    @foreach($productLists as $productList)
                    <option value="{{$productList->product_id}}">{{$productList->product->product_name}}-{{$productList->product->product_code}}</option>
                    @endforeach
                  </select>

                </td>
                <td><span class="quantity"></span></td>
                <td><input id="bookQuantity" type="text" name="bookQuantity[]" class="form-control" required autofocus></td>
                <td><input id="bookPrice" type="text" name="bookPrice[]" class="form-control" readonly required autofocus></td>
                <td><span class="total_price"></span></td>
                <td><input id="bookPercentage" type="text" name="bookPercentage[]" class="form-control" value="" required autofocus></td>
                <td><span class="net_price"></span></td>
              </tr></div>
            </tbody>
          </table>
          <div class="form-group">
            <div class="col-md-1 col-md-offset-10">
              <button type="button" class="btn btn-primary addButton" disabled="">
                <span class="fa fa-plus-square fa-lg"></span>  Add Product
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row ">
  <div class="col-md-12 invoice_print">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3>Invoice</h3>

        <button type="button" class="btn btn-primary pull-right print_btn" name="button" style="margin-top:-5%;"><span class="fa fa-print fa-3x "></span></button>

      </div>
      <div class="panel-body" class="printable" id="div1">
        @if(isset($tempsales))
        <span class="pull-left left">Invoice No:<input type="text" name="" class="invoiceNo" required="true" readonly value="{{$customer->invoice_id}}" /></span>
        @else
        <span class="pull-left left">Invoice No:<input type="text" name="" class="invoiceNo" required="true" readonly value="{{$newInvoice}}" /></span>
        @endif
        <span class="pull-right right">Date:<input type="text" name="" class="invoiceDate" required="true" readonly value="{{ \Carbon\Carbon::now(\App\Http\Controllers\CommonSetting::timezone())->format('d/m/Y') }}" /></span>

        <div class="text-center company_info">
          <div class="logo" style="display:inline-block;vertical-align:top; margin-top:6px;">
            <img src="/resources/assets/uploads/logo/{{getTheCompanyFavicon()}}" alt="logo not found" width="30" height="30">
          </div>
          <div class="info" style="display:inline-block;">
            <span class="companyName" style="font-size:30px; font-weight:bold;">{{getTheCompanyName()}}</span>
          </div><br />
          <span style=" font-size:20px; font-weight:bold;">{{getTheCompanyAddress()}}</span><br />
          <span style=" font-size:15px; font-weight:bold;">{{getTheCompanyPhnNo()}}</sapn>

          </div>
          <div class="text-center company_info">

            @if(isset($customerInfo))
            <input type="hidden" name="customerID" value="{{$customerInfo->id}}" class="customerID_text">
            <span>Customer Name:</span><input type="text" name="customerName" class="customerName" required="true" readonly="" value="{{$customerInfo->customer_name}}" />
            <span class="customer_name"></span><br />
            <span>Customer Address:</span><input type="text" name="customerAddress" class="customerAddress" required="true" readonly="" value="{{$customerInfo->address}}"/>
            <span class="customer_address"></span>
            @else
            <input type="hidden" name="customerID" value="" class="customerID_text">
            <span>Customer Name:</span><input type="text" name="customerName" class="customerName" required="true" readonly="" />
            <span class="customer_name"></span><br />
            <span>Customer Address:</span><input type="text" name="customerAddress" class="customerAddress" required="true" readonly="" />
            <span class="customer_address"></span>
            @endif
          </div>


          <table class="table table-bordered" id="invoiceTable">
            <tbody>
              <tr>
                <th>Quantity</th>
                <th>Product Name</th>
                <th>Price(unit)</th>
                <th>Total Price</th>
                <th>Discount</th>
                <th>Net Price</th>
              </tr>
              <tfoot>
                <tr>
                  <td colspan="5" style="text-align:right;"><h4>Delivery Charge:</h4></td>
                  <td><input type="text" class="form-control delivery" name="delivery" class="delivery" value="{{getTheDeliveryCharge()}}">
                    <span class="deliveryCharge" id="deliveryCharge"></span></td>
                  </tr>
                  <tr>
                    <td colspan="5" style="text-align:right;"><h4>Total amount</h4></td>
                    <td><span class="total_Amount"></span></td>
                  </tr>
                  <tr>
                    <td colspan="5" style="text-align:right;"><h4>Discount:</h4></td>
                    <td><input type="text" class="form-control reduce" name="reduced" class="reduced" value="0">
                      <span class="reducedAmount"></span>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="5" style="text-align:right;"><h4>Tax:</h4></td>
                    <td><div class="input-group">
                      <input type="text" class="form-control tax" name="tax" class="tax" value="{{getTheVat()}}"/>
                      <span class="input-group-addon">
                        <i class="fa fa-percent"></i>
                      </span>
                      <span class="taxAmount"></span>
                    </div>

                  </td>
                </tr>
                <tr>
                  <td colspan="5" style="text-align:right;"><h4>Net Amount:</h4></td>
                  <td><span class="netAmount" id="netAmount"></span></td>
                </tr>

                <tr>
                  <td colspan="3" style="text-align:right;"><h4>Payment method</h4></td>
                  <td><select class="form-control payment_method" name="payment_method" >
                    <option value="">-Select-</option>
                    <option value="1">PAID</option>
                    <option value="2">PARTIAL</option>
                    <option value="3">UNPAID</option>
                  </select> <span class="payment_methodText"></span></td>
                  <td><h4>Paid amount</h4></td>
                  <td><input class="form-control paid_amount" type="number" name="paid_amount" min="0"/>
                    <span class="paid_amountText"></span>
                  </td>
                </tr>
                <tr>
                  <td colspan="5" style="text-align:right;"><h4>Amount Due:</h4></td>
                  <td><span class="due"></span></td>
                </tr>
              </tfoot>
              @if(isset($tempsales))
              @foreach($tempsales as $tempsale)
              <tr>
                <td><input class="table-input book_quantity" type="text" name="book_quantity[]" value="{{$tempsale->book_quantity}}" readonly=""></td>
                <td><input type='hidden' class="book_id" name="book_id[]" value="{{$tempsale->book_id}}" /><input class="table-input book_name" type="text" name="book_name[]" value="{{$tempsale->book_name}}"readonly=""></td>
                <td><input class="table-input book_price" type="text" name="book_price[]" value="{{$tempsale->book_price}}"readonly=""></td>
                <td><input class="table-input total_price" type="text" name="total_price[]" value="{{$tempsale->total_price}}"readonly=""></td>
                <td><input class="table-input discount" type="text" name="discount[]" value="{{$tempsale->discount}}"readonly=""></td>
                <td class="combat"><input class="table-input net_price" type="text" name="net_price[]" value="{{$tempsale->net_price}}"readonly=""></td>
                <td class="hidden-val"><button type="button" class="btn btn-danger tempdelete" style="cursor:pointer; color:white;" value="{{$tempsale->id}}"><span class="fa fa-trash-o fa-2x"></span></td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
            <div class="invoiceFooter text-center">
              <span>Developed by: www.vencerlab.com | 01624823181</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @endsection

  @section('footer_scripts')
  <style media="screen">
  .customerName,.customerAddress,.invoiceNo,.invoiceDate
  {
    background: transparent;
    border: none;
    border-bottom: 1px dashed #83A4C5;
    width: 50%;
    outline: none;
    padding: 0px 0px 0px 0px;
    margin:2%;
    font-style: italic;
  }
  .table-input {
    border:0px;
  }
  .invoiceFooter{
    display: none;
  }

  .logo {
    display:inline-block;
    vertical-align:top;
    margin-top:6px;
  }


  </style>

  <script type="text/javascript">
  $(document).ready(function(){
    $(window).resize(function() {
      var mobileWidth =  (window.innerWidth > 0) ?
      window.innerWidth :
      screen.width;
      var viewport = (mobileWidth > 480) ?
      'width=device-width, initial-scale=1.0' :
      'width=1200';
      $("meta[name=viewport]").attr('content', viewport);
    }).resize();

    $('#bookName').select2();
    $('.customer').select2();
    $('#bookQuantity').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    $('#bookPrice').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    $('#bookPercentage').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

    var customerID = $(".customerID_text").val();
    var sum = 0;
    var delivery;
    var taxAmount;
    var taxWow;

    $('.combat').each(function () {

      $(this).find('input').each(function () {
        var combat = $(this).val();
        if (!isNaN(combat) && combat.length !== 0) {
          sum += parseFloat(combat);
        }
      });

    });
    delivery = $(".delivery").val();

    sum += parseFloat(delivery);

    $(".total_Amount").html(sum);
    taxWow = $(".tax").val();
    taxWow = parseInt((taxWow*sum)/100);
    sum += parseFloat(taxWow);

    $(".netAmount").html(sum);
    $(".due").html(sum);

    $(".delivery").on('focus', function(){
      delivery = $(this).val();

    });
    $(".delivery").on('blur',function(){
      var val = $(this).val();
      delivery = parseInt(val - delivery);
      var totalDelivery =  parseInt($(".total_Amount").html());
      var netDelivery = parseInt($(".netAmount").html());
      totalDelivery = parseFloat(totalDelivery + delivery);
      netDelivery = parseFloat(netDelivery + delivery);
      $(".total_Amount").html(totalDelivery);
      $(".netAmount").html(netDelivery);
    });

    $('.payment_method').on('change',function(){

      var payment = $(this).val();
      var netAmount = parseInt($("#netAmount").html());

      if(payment == "1")
      {
        $(".paid_amount").val(netAmount);
        $(".paid_amount").attr("readonly","true");
        $(".due").html("0");
      }
      if(payment == "3")
      {
        $(".paid_amount").val("0");
        $(".paid_amount").attr("readonly","true");
        $(".due").html(netAmount);
      }
      if(payment == "2") {
        $(".paid_amount").val("");
        $(".paid_amount").removeAttr("readonly");
      }


    });



    $('#bookName').on("change",function(){
      $.ajaxSetup(
        {
          headers:
          {'X-CSRF-Token': $('input[name="_token"]').val()}
        });
        var bookName = $(this).val();

        $.ajax({
          url:'./inventoriesdata',
          type:'POST',
          data:{bookName: bookName},

          success: function (data) {
            response=JSON.parse(data);

            $.each(response, function(index, element) {
              $(".quantity").html(element.quantity);
              $("#bookPrice").val(element.unit_price);
              $("#bookPercentage").val(element.percentage);
            });
            $(".total_price").html("");
            $(".net_price").html("");
            $('#bookQuantity').val("");
          }

        });
      });

      $('#bookQuantity').on('blur',function(){
        var quantity = parseInt($(".quantity").html());
        var givenQuantity = parseInt($('#bookQuantity').val());
        var bookPrice = parseInt($("#bookPrice").val());
        var percentage = parseInt($("#bookPercentage").val());

        if(quantity < givenQuantity )
        {
          $.alert({
            title: 'Low Quantity Alert!',
            content: 'Exceed Quantity!',
          });

          $('#bookQuantity').val("");
        }
        else {
          var total_price = (givenQuantity*bookPrice);
          var net_price = ((total_price/100)*percentage);
          var final_price = Math.round((total_price - net_price));

          $(".total_price").html(total_price);
          $(".net_price").html(final_price);

          $('.addButton').removeAttr('disabled');
        }
      });

      $("#bookPercentage").on('focus',function(){
        $('.addButton').attr('disabled','true');
      });

      $("#bookQuantity").on('focus',function(){
        $('.addButton').attr('disabled','true');
      });

      $("#bookPercentage").on('blur',function(){
        var quantity = parseInt($(".quantity").html());
        var givenQuantity = parseInt($('#bookQuantity').val());
        var bookPrice = parseInt($("#bookPrice").val());
        var percentage =parseInt($(this).val());
        if(quantity < givenQuantity )
        {
          $.alert({
            title: 'Less Quantity Alert!',
            content: 'Exceed Quantity!',
          });
          $('#bookQuantity').val("");
        }
        else {
          var total_price = (givenQuantity*bookPrice);
          var net_price = ((total_price/100)*percentage);
          var final_price = Math.round((total_price - net_price));

          $(".total_price").html(total_price);
          $(".net_price").html(final_price);

          $('.addButton').removeAttr('disabled');
        }
      });
      $(".tax").on('focus',function(){
        var taxhell = $(this).val();
        var totalTax = parseInt($(".total_Amount").html());
        var totalDiscount = $(".reduce").val();
        var net = (totalTax-totalDiscount);

        taxAmount = parseInt((net*taxhell)/100);
      });

      $(".tax").on('blur',function(){
        var tax = $(this).val();

        var totalTax = parseInt($(".total_Amount").html());
        var totalDiscount = $(".reduce").val();
        var net = (totalTax-totalDiscount);

        var tax = parseInt((net*tax)/100);

        var finalTax = parseInt(tax-taxAmount);

        var netPrice =  $(".netAmount").html();
        var TaxCount =  parseInt(netPrice) + parseInt(finalTax);
        $(".netAmount").html(TaxCount);
        var paid = $(".paid_amount").val();
        $(".due").html(TaxCount-paid);
      });


      $(".reduce").on('blur',function(){
        var reduce = $(this).val();
        var main_price =  parseInt($(".total_Amount").html());
        var tax = $('.tax').val();
        $(".netAmount").html(main_price-reduce);
        var net = $(".netAmount").html();
        var taxCount = parseInt((net*tax)/100);
        taxAmount = taxCount;
        net = parseInt(net) + parseInt(taxCount);
        $(".netAmount").html(net);
        var paid = $(".paid_amount").val();
        $(".due").html(net-paid);
      });

      $(".paid_amount").click(function(){
        var netValue = parseInt($(".netAmount").html());
        $(this).attr('max',netValue);
      });

      $(".paid_amount").on('blur',function(){
        var paid = $(this).val();
        var net = $(".netAmount").html();
        $(".due").html(net-paid);

      });

      $(".deletepos").click(function(){
        $.confirm({
          title: 'Delete Invoice!',
          content: 'Are you sure!',
          buttons: {

            confirm: {
              text: 'confirm',
              btnClass: 'btn-blue',
              keys: ['enter', 'shift'],
              action: function(){
                window.location.href="./deletetemp";
              }
            },
            cancel: {
              text: 'cancel',
              btnClass: 'btn-red',
              keys: ['enter', 'shift'],
              action: function(){
                $.alert('Canceled!');
              }
            }


          }
        });

      });

      $(".customer").on('change',function(){

        customerID = $(this).val();
        $(".customerID_text").val(customerID);

        $.ajaxSetup(
          {
            headers:
            {'X-CSRF-Token': $('input[name="_token"]').val()}
          });

          $.ajax({
            url:'./customerdata',
            type:'POST',
            data:{customerID: customerID},

            success: function (data) {
              response=JSON.parse(data);

              $.each(response, function(index, element) {
                $(".customerID").val(element.id);
                $(".customerName").val(element.customer_name);
                $(".customerAddress").val(element.address);
              });
            }

          });
        });

        $('.addButton').click(function(){
          if($(".quantity").html() == "")
          {
            $.alert({
              title: 'Select Product',
              content: 'No product selected!',
            });

          }
          else if($(".customer").val() == "")
          {
            $.alert({
              title: 'Select Customer',
              content: 'No customer selected!',
            });

          }
          else {

            var totalAmount = parseInt($(".total_Amount").html());
            var invoice = $(".invoiceNo").val();

            var bookID = $('#bookName').val();
            var bookName = $( "#bookName option:selected" ).text().split("-").pop();
            var bookQuantity = $('#bookQuantity').val();
            var bookPrice = $('#bookPrice').val();
            var total_price = $('.total_price').html();
            var bookPercentage = $('#bookPercentage').val();
            var net_price = parseInt($('.net_price').html());
            var taxVal = $(".tax").val();
            var delivery = $(".delivery").val();
            var reduced = $(".reduce").val();



            totalAmount = parseInt(totalAmount+net_price);
            $(".total_Amount").html(totalAmount);
            totalAmount = totalAmount-reduced;
            var taxValue = parseInt((totalAmount*taxVal)/100);
            taxValue = parseInt(taxValue)+ parseInt(totalAmount);
            $(".netAmount").html(taxValue);
            $(".due").html(taxValue);
            customerID =$(".customerID_text").val();

            $.ajaxSetup(
              {
                headers:
                {'X-CSRF-Token': $('input[name="_token"]').val()}
              });

              $.ajax({
                url:'./tempsales',
                type:'POST',
                data:{bookID: bookID,bookName: bookName, bookQuantity : bookQuantity, bookPrice: bookPrice, total_price: total_price, bookPercentage: bookPercentage, net_price: net_price, customerID: customerID, invoice:invoice },

                success: function (data) {
                  var temporary = data;

                  $("#invoiceTable tbody tr:last").after("<tr><td><input class='table-input book_quantity' type='text' name='book_quantity[]' value='"+bookQuantity+"'readonly></td><td><input type='hidden' class='book_id' name='book_id[]' value='"+bookID+"' class='bookID' /><input class='table-input book_name' type='text' name='book_name[]' value='"+bookName+"'readonly></td><td><input class='table-input book_price' type='text' name='book_price[]' value='"+bookPrice+"'readonly></td><td><input class='table-input total_price' type='text' name='total_price[]' value='"+total_price+"'readonly></td><td><input class='table-input discount' type='text' name='discount[]'value='"+bookPercentage+"'readonly></td><td><input class='table-input net_price' type='text' name='net_price[]' value='"+net_price+"'readonly></td><td class='hidden-val'><button type='button' class='btn btn-danger deleteRow' style='cursor:pointer; color:white;' value='"+temporary+"'> <span class='fa fa-trash-o fa-2x'></span></td></tr>");
                  $('#bookName').select2('val', 'All');
                  $('#bookQuantity').val("");
                  $('#bookPrice').val("");
                  $('.total_price').html("");
                  $('#bookPercentage').val("");
                  $('.net_price').html("");
                  $(".quantity").html("");
                  $('.addButton').attr('disabled','true');

                }

              });
            }
          });

          $("#invoiceTable").on("click",".deleteRow",function(){
            var temp = $(this).val();
            var net_price = $(this).closest("td").prev().find("input[type='text']").val();

            $.ajaxSetup(
              {
                headers:
                {'X-CSRF-Token': $('input[name="_token"]').val()}
              });

              $.ajax({
                url:'./delsalerow',
                type:'POST',
                data:{temp: temp},
                success: function (data) {
                  var total = parseInt($(".total_Amount").html());
                  var net = parseInt($(".netAmount").html());

                  $(".total_Amount").html(total-net_price);
                  $(".netAmount").html(net-net_price);
                  $(".due").html(net-net_price);
                  $(".deleteRow").filter(function(){return this.value==temp}).parents('tr').first().remove();
                }

              });


            });


            $(".tempdelete").click(function(){

              var temp = $(this).val();
              var net_price = $(this).closest("td").prev().find("input[type='text']").val();


              $.ajaxSetup(
                {
                  headers:
                  {'X-CSRF-Token': $('input[name="_token"]').val()}
                });

                $.ajax({
                  url:'./delsalerow',
                  type:'POST',
                  data:{temp: temp},
                  success: function (data) {
                    var total = parseInt($(".total_Amount").html());
                    var net = parseInt($(".netAmount").html());

                    $(".total_Amount").html(total-net_price);
                    $(".due").html(net-net_price);
                    $(".netAmount").html(net-net_price);
                    $(".tempdelete").filter(function(){return this.value==temp}).parents('tr').first().remove();
                  }

                });

              });


              $(".print_btn").click(function(){

                //var users = $('input:text.users').serialize();
                if($(".payment_method").val() == "")
                {
                  $.alert({
                    title: 'Add payment details',
                    content: 'Please complete payment details',
                  });

                }
                else if($(".paid_amount").val() == "")
                {
                  $.alert({
                    title: 'Add payment details',
                    content: 'Please complete payment details',
                  });

                }
                else if(customerID == 1 && $(".payment_method").val() != 1)
                {
                  $.alert({
                    title: 'Walking customer',
                    content: 'Walk in Customer cannot be Unpaid/ Partial',
                  });

                }
                else {
                  var book_quantity = $('input[name="book_quantity[]"]').map(function(){
                    return this.value;
                  }).get();
                  var book_id = $('input[name="book_id[]"]').map(function(){
                    return this.value;
                  }).get();
                  var book_price = $('input[name="book_price[]"]').map(function(){
                    return this.value;
                  }).get();
                  var total_price =  $('input[name="total_price[]"]').map(function(){
                    return this.value;
                  }).get();
                  var discount =  $('input[name="discount[]"]').map(function(){
                    return this.value;
                  }).get();
                  var net_price =  $('input[name="net_price[]"]').map(function(){
                    return this.value;
                  }).get();

                  //customerID
                  var invoiceNO = $(".invoiceNo").val();

                  var payment = $(".payment_method").val();
                  var paid_amount = $(".paid_amount").val();
                  var netAmount = parseInt($("#netAmount").html());
                  var taxVal = $(".tax").val();
                  var delivery = $(".delivery").val();
                  var reduced = $(".reduce").val();

                  //alert(book_id);

                  $.ajaxSetup(
                    {
                      headers:
                      {'X-CSRF-Token': $('input[name="_token"]').val()}
                    });

                    $.ajax({
                      url:'./postsale',
                      type:'POST',
                      data:{'book_quantity[]': book_quantity,'book_id[]': book_id, 'book_price[]' : book_price, 'total_price[]': total_price, 'discount[]': discount, 'net_price[]': net_price, customerID: customerID, invoiceNO: invoiceNO, netAmount: netAmount,payment: payment, paid_amount: paid_amount, taxVal:taxVal,reduced : reduced, delivery:delivery },
                      success: function (data) {
                        $(".print_btn").css("display","none");
                        $(".customer_name").html($(".customerName").val());
                        $(".customer_address").html($(".customerAddress").val());
                        $(".reducedAmount").html($(".reduce").val());
                        $(".paid_amountText").html($(".paid_amount").val());
                        $(".payment_methodText").html($(".payment_method option:selected").text());
                        $(".deliveryCharge").html($(".delivery").val());
                        $(".taxAmount").html($(".tax").val()+"%");

                        $(".customerName").css("display","none");
                        $(".customerAddress").css("display","none");
                        $(".reduce").css("display","none");
                        $(".delivery").css("display","none");
                        $(".tax").css("display","none");
                        $(".payment_method").css("display","none");
                        $(".paid_amount").css("display","none");

                        var printDivCSS = new String ('<style>input[type=text] {border:0px;} table{border-collapse: collapse;width: 100%;} td, th{border: 1px solid #dddddd;text-align:left;padding: 8px;} tr:nth-child(even){background-color: #dddddd;} .company_info{text-align:center; margin-bottom:5%;} .left{text-align:left;} .right{margin-left:50%;} .logo{display:inline-block;vertical-align:top; margin-top:6px;} .hidden-val{display:none;} .footer{margin-top: 15%; text-align:right;}  body{margin: 10mm 10mm 10mm 10mm;} @page{size:auto; margin: 0mm} .invoiceFooter {position: fixed; bottom: 0; font-size:8px; text-align:center;}</style>');

                        var newWindow = window.open();
                        newWindow.document.write('<html><head>'+ printDivCSS +'</head><body>'+ document.getElementById("div1").innerHTML);
                        newWindow.document.write('<div class="footer">Signature: _____________');
                        newWindow.document.write('</body></html>');
                        newWindow.print();
                        $.confirm({
                          title: 'Document Printed!',
                          content: 'your Documents is ready for print!',
                          buttons: {
                            confirm: {
                              text: 'confirm',
                              btnClass: 'btn-blue',
                              keys: ['enter', 'shift'],
                              action: function(){
                                window.location.href="./invoice";
                              }
                            }
                          }
                        });

                      }

                    });
                  }
                });

              });
</script>
@endsection
