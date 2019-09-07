@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>Categories</h3>
        </div>
        <div class="panel-body">
          <table class="table" id="category-list-table">
            <thead>
              <th>ID</th>
              <th>Category Name</th>
              <th>Action</th>
            </thead>
            <tbody>
              @foreach($categoryListings as $categoryListing)
              <tr>
                <td>{{$categoryListing->id}}</td>
                <td class="category_name">{{$categoryListing->category_name}}</td>
                <td>
                  <span class="fa fa-pencil deleteModal" style="cursor:pointer"  title="Edit" data-toggle="modal" data-target="#deleteCategory" id="{{$categoryListing->id}}" value="{{$categoryListing->category_name}}">
                  </span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>Add Category</h3>
        </div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" method="POST" action="{{ url('addCategory') }}">
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
      </div>
    </div>
  </div>
</div>


<!-- modal of deleteCategory -->
<div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4>Are you sure?</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('deleteCategory') }}">
          {{ csrf_field() }}
          <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
              <input type="hidden" name="deleteThisId" value="" id="thisID" class="form-control" readonly="">
              <input type="text" name="editCategory" value="" id="thiscategory" class="form-control" >
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
              <button type="submit" class="btn btn-primary">
                Submit
              </button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- modal of deleteCategory-end -->
@endsection

@section('footer_scripts')

<script>
$(document).ready(function(){
  $('#category-list-table').DataTable({
    "order": [[ 0, "desc" ]],
    "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
  });
});

$(document).on("click", ".deleteModal", function () {
  var categoryId = $(this).attr('id');
  var categoryName = $(this).attr('value');
  $(".modal-body #thiscategory").val(categoryName);
  $(".modal-body #thisID").val(categoryId);
});
</script>

@endsection
