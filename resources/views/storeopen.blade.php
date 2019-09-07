
@extends('layouts.app')

@section('content')
<div class="row text-center">

  <div class="col-xs-12 col-md-12" style="color:#FFF" >
    <div class="panel" style="background-color:#ff3333">
      <div class="panel-heading">
      </div>
      <div class="panel-body">
        <h3>You are using <b style="font-size:25px;">7 Days</b>  trail Version </h3>
        <h4>Expiring Date: 07.05.2017</h4>
      </div>
    </div>
  </div>


</div>
<div class="container">
  <div class="col-md-7 col-md-offset-2">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <h1>{{$companyInfo->company_name}}</h1>
              <h4>{{$companyInfo->phone_number}}</h4>
              <h5>{{$companyInfo->address}}</h5>
            </div>
            <div class="col-md-2" style="margin-top:3%;">
              <button data-toggle="modal" data-target="#storeOpen" type="button" name="button" class="btn btn-success">
                Welcome {{ Auth::user()->name }},<br />
                <b>Click to Open Store</b>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- modal -->
<div class="modal fade" id="storeOpen" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4>Cash In Hand</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('changeStoreOpen') }}">
          {{ csrf_field() }}

          <div class="form-group">
            <label for="cashInHand" class="col-md-4 control-label">Cash In Hand</label>
            <div class="col-md-6">
              <input type="hidden" name="previousCashInHand" value="{{getTheCashInHand()}}">
              {{getTheCashInHand()}}
            </div>
          </div>
          <div class="form-group">
            <input type="hidden" name="storeStatus" value="no">
            <label for="extraCashInHand" class="col-md-4 control-label">Add More Cash In Hand</label>
            <div class="col-md-6">
              <input id="extraCashInHand" type="text" class="form-control" name="extraCashInHand" autofocus>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
              <button type="submit" class="btn btn-primary">
                Submit
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- model-end -->
@endsection
