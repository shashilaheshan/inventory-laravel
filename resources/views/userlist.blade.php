@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-heading"><h3>Users List</h3>
        </div>
        <div class="panel-body" id ="div1">
          <table class="table" id="user-list-table">
            <thead>
              <th class="hidden-xs">ID</th>
              <th>Name</th>
              <th class="hidden-xs">Email</th>
              <th>Role</th>
              <th>Action</th>
            </thead>
            <tbody>
              @foreach($userLists as $userList)
              <tr>
                <td class="id hidden-xs">{{$userList->id}}</td>
                <td >{{$userList->name}}</td>
                <td class="hidden-xs" >{{$userList->email}}</td>
                <td>{{$userList->role}}</td>
                <td>
                  <span class="fa fa-close fa-lg deleteUser" style="cursor:pointer" title="Delete">
                  </span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('footer_scripts')
<script type="text/javascript">
  $(document).ready(function(){

    $('#user-list-table').DataTable({
      "order": [[ 0, "desc" ]],
        "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
    });

    $('.deleteUser').click(function(){
      var id = $(this).closest('tr').children('td.id').html();

      $.confirm({
        title: 'Delete User',
        content: 'Are you sure?',
        buttons: {
          confirm: {
            text: 'confirm',
            btnClass: 'btn-blue',
            keys: ['enter', 'shift'],
            action: function(){
              window.location.href="./deleteuser/"+id;
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
  });
</script>
@endsection
