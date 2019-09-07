@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">

    <div class="col-md-8 col-md-offset-2">
      @if (Session::has('bookAdded'))
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('bookAdded') }}
      </div>
      @endif
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3> Add Purchased Products Quantity</h3>
        </div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" method="POST" action="{{ url('addQuantity') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="invoiceID" class="col-md-3 control-label">Invoice No.</label>
              <div class="col-md-7">
                <input id="invoiceID" type="text" class="form-control" name="invoiceID" autofocus>
              </div>
            </div>
            <div class="form-group">
              <label for="vendorText" class="col-md-3 control-label">Supplier's Name</label>
              <div class="col-md-7 text">
                <input id='vendorText' type='text' class='form-control' name='vendorID' readonly style="display:none;">
                <select id="vendorID" class="form-control" name='vendorID' required="">
                  <option value="">-Select-</option>
                  @foreach($vendorNames as $vendorNames)
                  <option value="{{$vendorNames->id}}">{{$vendorNames->vendor_name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="products">
              <div class="form-group">
                <label for="productID" class="col-md-3 control-label">Product Name</label>
                <div class="col-md-3">
                  <select class="single form-control" id="id_label_single" name="productID[]"  required="">

                  </select>

                </div>
                <label for="bookQuantity" class="col-md-2 control-label">Quantity</label>
                <div class="col-md-2">
                  <input id="bookQuantity" type="text" class="form-control" name="bookQuantity[]" autofocus>
                </div>
                <a style="display:none;" class="closeEverything" href="javascript:void(0)" onclick="SomeDeleteRowFunction(this)">+Delete this Row</a>
              </div>

            </div>
            <div class="addrow">

            </div>
            <div class="text-center">
              <a class="addMore" href="javascript:void(0)">+Add more products</a>
              <a style="display:none;" class="addMore2" href="javascript:void(0)">+add more products</a>

            </div>

            <div class="form-group">
              <label for="totalPurchase" class="col-md-3 control-label">Total Payment (BDT)</label>
              <div class="col-md-7">
                <input id="totalPurchase" type="number" class="form-control" name="totalPurchase" autofocus>
              </div>
            </div>
            <div class="form-group">
              <label for="fromWhere" class="col-md-3 control-label">From Where</label>
              <div class="col-md-7">
                <select id="fromWhere" type="number" class="form-control" name="fromWhere" required="">
                  <option value="">-select-</option>
                  <option value="1">From Cash</option>
                  <option value="2">From Hand</option>
                </select>
              </div>
            </div>
            <div class="form-group amount_paid">
              <label for="amountPaid" class="col-md-3 control-label">Amount Paid</label>
              <div class="col-md-7">
                <input id="amountPaid" type="number" class="form-control" name="amountPaid"/>
              </div>
              <span> In Cash: <span class="cash">{{getTotalEarningOfToday()-getTotalExpenseOfToday()}}</span></span>
            </div>
            <div class="form-group">
              <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary submit" style="margin-left:55%;">
                  Submit
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
</div>

@endsection

@section('footer_scripts')
<script type="text/javascript" src="{{ asset('js/inventory.js') }}"></script>
<script type="text/javascript">
$('.single').select2();
var response="";
var option = "";

function SomeDeleteRowFunction(o) {
  $(o).parents('div[class=form-group]').remove();
}

$(".addMore").click(function() {

  $("#invoiceID").attr('readonly', 'true');
  var vendorID = $("#vendorID").val();
  $("#vendorText").val(vendorID);
  $("#vendorID").css('display', 'none');
  $("#vendorText").css('display', 'block');
  $(".single").select2("destroy");
  option = $(".products").html();
  $("#id_label_single").removeClass("single");
  $(".closeEverything").remove();
  $('.addrow').html(option);
  $('.single').select2();
  $('.addMore').css('display', 'none');
  $('.addMore2').css('display', 'block');
  $('.closeEverything').css('display', 'block');
});

$('.addMore2').click(function() {
  $(".products").html();

  $('.addrow').append(option);
  $('.single').select2();
  $('.closeEverything').css('display', 'block');

});



$("#vendorID").select(function() {
  $("#vendorText").val(vendorID);
});

$("#vendorID").on('change',function(){
  var vendor = $(this).val();
  $('.single').empty();
  $.ajaxSetup(
    {
      headers:
      {'X-CSRF-Token': $('input[name="_token"]').val()}
    });
    //alert(data);
    $.ajax({
      url:'./productlist',
      type:'POST',
      data:{vendor: vendor},

      success: function (data) {
        response=JSON.parse(data);

        $.each(response, function(index, element) {

          $('.single').append("<option value="+element.id+">"+element.product_name+"-"+element.product_code+"</option>");
        });
      }
    });
  });

  $("#amountPaid").on('click',function(){
    var value = $("#totalPurchase").val();
    $(this).attr('max',value);
  });

  $('#fromWhere').on('change',function(){

    var select = $(this).val();
    var cash = parseInt($('.cash').html());

    if(select == 1)
    {
      if($("#amountPaid").val() - cash > 0)
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

  $('.amount_paid').on('keyup','#amountPaid',function(){
    var cash = parseInt($('.cash').html());

    if($("#fromWhere").val() == 1)
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

  </script>
  @endsection
