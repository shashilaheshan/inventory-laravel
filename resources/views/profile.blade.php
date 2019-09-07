@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <img src="/resources/assets/uploads/avatars/{{ $user->avatar }}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
      <h2>{{ ucfirst($user->name) }}'s Profile</h2>
      <form enctype="multipart/form-data" action="/profile_edit" method="POST">
        <label>Update Profile Image</label>
        <input type="file" name="avatar">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="pull-right btn btn-sm btn-primary" value="Change">
      </form>
    </div>
  </div>
  <div class="row" style="margin-top:25px;">
    <div class="col-md-8 col-md-offset-2">
      @if (Session::has('passwordChangeStatusYes'))
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('passwordChangeStatusYes') }}
      </div>
      @endif
      @if (Session::has('passwordChangeStatusNo'))
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('passwordChangeStatusNo') }}
      </div>
      @endif
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Change Password</h4>
        </div>
        <div class="panel-body text-center">
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/password_change') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="old_password" class="col-md-4 control-label">Old Password</label>
              <div class="col-md-6">
                <input id="old_password" type="password" class="form-control" name="old_password" required autofocus>
              </div>
            </div>
            <div class="form-group">
              <label for="new_password" class="col-md-4 control-label">New Password</label>
              <div class="col-md-6">
                <input id="new_password" type="password" class="form-control" name="new_password" required autofocus>
              </div>
            </div>
            <div class="form-group">
              <label for="confirm_password" class="col-md-4 control-label">Confirm Password</label>
              <div class="col-md-6">
                <input id="confirm_password" type="password" class="form-control" name="confirm_password" required autofocus>
                <div class="check_password"></div>
              </div>
            </div>
            <div class="form-group">
              <label for="confirm_password" class="col-md-4 control-label"></label>
              <div class="col-md-6">
                <input type="submit" class="btn btn-sm btn-primary" id="submit_btn" value="Change Password">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('footer_scripts')
<script>
$(document).ready(function(){
  $("#confirm_password").keyup(function () {
    var newpassword = $("#new_password").val();
    var confirmPassword = $("#confirm_password").val();
    if (newpassword !== confirmPassword){
      $(".check_password").html("<strong>Passwords do not match!</strong>");
      $(".check_password").css("color","#DD5454");
      $("#submit_btn").attr("disabled",true);

    }
    else{
      $(".check_password").html("<strong>Passwords match.</strong>");
      $(".check_password").css("color","#21763D");
      $("#submit_btn").attr("disabled",false);
    }
  });
  $("#new_password").keyup(function () {
    var newpassword = $("#new_password").val();
    var confirmPassword = $("#confirm_password").val();
    if (newpassword !== confirmPassword){
      $(".check_password").html("<strong>Passwords do not match!</strong>");
      $(".check_password").css("color","#DD5454");
      $("#submit_btn").attr("disabled",true);
    }
    else{
      $(".check_password").html("<strong>Passwords match.</strong>");
      $(".check_password").css("color","#21763D");
      $("#submit_btn").attr("disabled",false);
    }
  });
});
</script>
@endsection
