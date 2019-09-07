<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon -->
    <link rel="shortcut icon" href="/resources/assets/uploads/logo/{{getTheCompanyFavicon()}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{getTheCompanyName()}}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- font awsome css -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css')}}">

    <!-- data table css -->
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css')}}">

    <!-- select2 css -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css')}}">

    <!-- Confirm css -->
    <link rel="stylesheet" href="{{ asset('css/jquery-confirm.min.css')}}">

    <script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
    </script>
    <!-- for any kind of chart -->
    {!! Charts::assets() !!}
    <style media="screen">

    html {
      height: 100%;
      box-sizing: border-box;
    }

    *,
    *:before,
    *:after {
      box-sizing: inherit;
    }

    body {
      position: relative;
      margin: 0;
      padding-bottom: 6rem;
      min-height: 100%;
    }

    .demo {
      margin: 0 auto;
    }


.footer {
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  padding: 1rem;
  width: 100%;
  background-color: #efefef;
  text-align: center;
}
    </style>
</head>
<body>
    <div id="app" class="appBlade">
        <nav class="navbar navbar-default navbar-static-top"
        style="-moz-box-shadow: 0px 2px 12px 1px #ccc;
              -webkit-box-shadow: 0px 2px 12px 1px #ccc;
              box-shadow: 0px 2px 12px 1px #ccc;">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        {{getTheCompanyName()}}
                        <!-- This function coming for helpers model -->
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if (!Auth::guest())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position:relative;">
                                    <span class="fa fa-plus-square"></span> Add <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/vendors') }}"><span class="fa fa-user"></span> Suppliers</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/categories') }}"><span class="fa fa-bookmark"></span> Categories</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/products') }}"><span class="fa fa-book"></span> Products</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/customers') }}"><span class="fa fa-users"></span> Customers</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/expense') }}"><span class="fa fa-money"></span> Expense</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/damages') }}"><span class="fa fa-trash"></span> Damage</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ url('/inventories') }}"><span class="fa fa-shopping-basket"></span> Purchase</a>
                            </li>
                                <li>
                                    <a href="{{ url('/invoice') }}"><span class="fa fa-file-text"></span> Sales</a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position:relative;">
                                        <span class="fa fa-files-o"></span> Ledgers <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ url('/vendorledger') }}"><span class="fa fa-file-excel-o"></span> Suppliers</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/customerledger') }}"><span class="fa fa-file-word-o"></span> Customers</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position:relative;">
                                    <span class="fa fa-line-chart"></span> Reports <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/purchasereport') }}">
                                            <span class="fa fa-pie-chart"></span> Purchase Report
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/sale') }}">
                                            <span class="fa fa-area-chart"></span> Sales Report
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/expense') }}">
                                            <span class="fa fa-bar-chart"></span> Expense Report
                                        </a>
                                    </li>
                                </ul>
                                </li>
                                <li>
                                    <a href="{{ url('/alert') }}">
                                        <span class="fa fa-exclamation-triangle"></span> Alert <span style="background-color: rgb(221, 84, 84); font-weight: bold; padding: 0px 5px 2px 5px; color: rgb(255, 255, 255); border-radius: 3px;">{{ getAlertBookAmount() }}</span>
                                    </a>
                                </li>
                                @if (Auth::user()->role == 'admin')
                                <li>
                                    <a href="{{ url('/settings') }}"><span class="fa fa-wrench"></span> Settings</a>
                                </li>
                                @endif
                            @endif
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())

                            @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position:relative; padding-left:50px;">
                                    <img src="/resources/assets/uploads/avatars/{{ Auth::user()->avatar }}" style="width:32px; height:32px; position:absolute; top:10px; left:10px; border-radius:50%">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/profile') }}">
                                            <span class="fa fa-user"></span> Profile
                                        </a>
                                    </li>
                                    @if (Auth::user()->role == 'admin')
                                    <li>
                                        <a href="{{ url('/register') }}">
                                            <span class="fa fa-user-plus"></span> Create User
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        <span class="fa fa-sign-out"></span> Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
        @if(Request::path() === 'login' || Request::path() === 'register' || Request::path() === 'storeclose')

        @else
            <span data-toggle="modal" data-target="#storeClose" class="fa fa-close fa-2x storeClose" style=" cursor:pointer ; background-color: rgb(221, 84, 84); padding: 5px; color: rgb(255, 255, 255); position:absolute;top:73px;right:0px" title="Close Store"></span>
        @endif

        <div class="modal fade" id="storeClose" tabindex="-1" role="dialog" aria-labelledby="youtubePage">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Close Store
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('changeStoreClose') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="todaysDate" class="col-md-4 control-label">Today's Date</label>
                                <div class="col-md-6">
                                    {{getTodaysDate()}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="categoryName" class="col-md-4 control-label">Today's Total Earning</label>
                                <div class="col-md-6">
                                    {{getTheCurrency()}} {{getTotalEarningOfToday()}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="categoryName" class="col-md-4 control-label">Today's Total Expense</label>
                                <div class="col-md-6">
                                    {{getTheCurrency()}} {{getTotalExpenseOfToday()}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mayHave" class="col-md-4 control-label">You Should Have</label>
                                <div class="col-md-6">
                                    <input type="hidden" name="mayHave" value="{{getTotalEarningOfToday()-getTotalExpenseOfToday()}}">
                                    {{getTheCurrency()}} {{getTotalEarningOfToday()-getTotalExpenseOfToday()}}
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="storeStatus" value="yes">
                                <label for="takeFromCash" class="col-md-4 control-label">Take From Cash</label>
                                <div class="col-md-6">
                                    <input id="takeFromCash" type="number" class="form-control" name="takeFromCash" autofocus max="{{getTotalEarningOfToday()-getTotalExpenseOfToday()}}">
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



    </div>
    <div class="footer">
     <b>Copyright &copy; {{date('Y')}}</b>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('js/select2.min.js')}}"></script>
    <script src="{{ asset('js/jquery-confirm.min.js')}}"></script>
    @yield('footer_scripts')

</body>
</html>
