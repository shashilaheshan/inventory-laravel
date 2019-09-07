@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><h3>Restore Suppliers</h3></div>

                <div class="panel-body">
                    <table class="table" id="vendor-restore-list-table">
                        <thead>
                            <th>Name</th>
                            <th class="hidden-xs">Phone Number</th>
                            <th >Address</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($deletedVendorLists as $deletedVendorList)
                                <tr>
                                    <td>{{$deletedVendorList->vendor_name}}</td>
                                    <td class="hidden-xs">{{$deletedVendorList->phone_number}}</td>
                                    <td>{{$deletedVendorList->address}}</td>
                                    <td>
                                        <form role="form" method="POST" action="{{ url('restoreVendor') }}">
                                            {{ csrf_field() }}
                                            <button type="submit" name="whichVendor" value="{{$deletedVendorList->id}}" title="Restore">
                                                <span class="fa fa-refresh"></span>
                                            </button>
                                        </form>
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

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><h3>Restore Customer</h3></div>

                <div class="panel-body">
                    <table class="table" id="customer-restore-list-table">
                        <thead>
                            <th>Name</th>
                            <th class="hidden-xs">Phone Number</th>
                            <th>Address</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($deletedCustomerLists as $deletedCustomerList)
                                <tr>
                                    <td>{{$deletedCustomerList->customer_name}}</td>
                                    <td class="hidden-xs">{{$deletedCustomerList->phone_number}}</td>
                                    <td>{{$deletedCustomerList->address}}</td>
                                    <td>
                                        <form role="form" method="POST" action="{{ url('restoreCustomer') }}">
                                            {{ csrf_field() }}
                                            <button type="submit" name="whichCustomer" value="{{$deletedCustomerList->id}}" title="Restore">
                                                <span class="fa fa-refresh"></span>
                                            </button>
                                        </form>
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
    <script>
        $(document).ready(function(){
            $('#vendor-restore-list-table').DataTable({
                "order": [[ 0, "asc" ]],
                  "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
            });
            $('#customer-restore-list-table').DataTable({
                "order": [[ 0, "asc" ]],
                  "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ]
            });
        });
    </script>
@endsection
