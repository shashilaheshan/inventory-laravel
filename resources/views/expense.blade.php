@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 everyData">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>Expenses</h3>
          <button class="btn btn-info btn-lg pull-right actionBtn" ><span class="fa fa-print fa-2x"></span></button>
          <button class="btn btn-info btn-lg pull-right pdf_btn" ><span class="fa fa-download fa-2x"></span></button>

        </div>
        <div class="panel-body detailsDiv" id="expense_table">
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

            <table class="table" id="expense-list-table">

              <thead>
                <th class="hidden-xs print">Time</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Reason</th>
              </thead>
              <tbody>
                @foreach($expenseListings as $expenseListing)
                <tr>
                  <td class="hidden-xs print">{{$expenseListing->created_at}}</td>
                  <td>{{$expenseListing->giveMeExpenseCategoryName()}}</td>
                  <td>{{$expenseListing->amount}}</td>
                  <td>{{$expenseListing->reason}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-4 everyData">
        @if (Auth::user()->role == 'admin')
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3>Expense Category</h3>
          </div>
          <div class="panel-body">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addCategory"><span class="fa fa-plus fa-lg"></span> Add Category</button>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editCategory"><span class="fa fa-pencil fa-lg"></span> Edit Category</button>
          </div>
        </div>
        @endif
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3>Add Expense</h3>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('addExpense') }}">
              {{ csrf_field() }}

              <div class="form-group">
                <label for="category" class="col-md-4 control-label">Category</label>
                <div class="col-md-6">
                  <select id="category" class="form-control" name="category" required="">
                    <option value="">-Select-</option>
                    @foreach($expenseCategories as $expenseCategorie)
                    <option value="{{$expenseCategorie->id}}">{{$expenseCategorie->category_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="amount" class="col-md-4 control-label">Amount</label>
                <div class="col-md-6">
                  <input id="amount" type="number" class="form-control" name="amount" required autofocus max="{{getTotalEarningOfToday()}}">
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
</div>

<!-- modal of addCategory -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="youtubePage">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4>Add Expense Category</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('addExpenseCategory') }}">
          {{ csrf_field() }}

          <div class="form-group">
            <label for="categoryName" class="col-md-4 control-label">Category Name</label>
            <div class="col-md-6">
              <input id="categoryName" type="text" class="form-control" name="categoryName" required autofocus>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- modal of addCategory-end -->

<!-- modal of editCategory -->
<div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="youtubePage">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4>Edit Expense Category</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('editExpenseCategory') }}">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="oldCategoryName" class="col-md-4 control-label">Category</label>
            <div class="col-md-6">
              <select id="oldCategoryId" class="form-control" name="oldCategoryId" required="">
                <option value="">-Select-</option>
                @foreach($expenseCategories as $expenseCategorie)
                <option value="{{$expenseCategorie->id}}">{{$expenseCategorie->category_name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="newCategoryName" class="col-md-4 control-label">New Category Name</label>
            <div class="col-md-6">
              <input id="newCategoryName" type="text" class="form-control" name="newCategoryName" required autofocus>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- modal of editCategory-end -->
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
  $('#expense-list-table').DataTable({
    "order": [[ 0, "desc" ]],
    "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
  });

  $('.pdf_btn').click(function(){
    $(".print").removeClass('hidden-xs');


    var data = $('#expense-list-table').html();
    var pdfName = "Expense";
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

    $("#expense-list-table_length").css('display','none');
    $("#expense-list-table_filter").css('display','none');
    $("#expense-list-table_info").css('display','none');
    $("#expense-list-table_paginate").css('display','none');
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

    $("#expense-list-table_length").css('display','block');
    $("#expense-list-table_filter").css('display','block');
    $("#expense-list-table_info").css('display','block');
    $("#expense-list-table_paginate").css('display','block');
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
