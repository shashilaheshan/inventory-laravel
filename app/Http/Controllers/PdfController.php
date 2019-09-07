<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense as Expense;
use App\Expense_categorie as Expense_categorie;
use PDF;



class PdfController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('storestatus');
  }


  public function expensePDF(){

    if($_POST['data'])
    {
      $data = $_POST['data'];
      $namePdf = $_POST['pdfName'];
      session(['value' => $data]);
      session(['pdfName' => $namePdf]);
    }
    echo session()->get('value');
  }


  public function printPdf()
  {
    $htmlData = "
    <html>
    <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js'></script>
        <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
    <style>
    @page{size:auto; margin: 0mm 5mm 0mm 5mm;}
    #header { position: fixed; left: 0px; top: 0px; right: 0px; height: 100px;}
    #footer { position: absolute; right: 0; bottom: 0; left: 0; width: 100%; text-align: center;}
    #footer .page:after { content: counter(page, upper-roman);}
    #content {margin-top:105px; margin-bottom:10px;text-align: center; }
    .title{margin-left:20px;}
    table{width:95%;}
    .hidden-val{display:none;}
    hr{background-color:black;}
    </style>
    </head>
    <body>
    <div id='header'>

    <div class='companyInfo'>
              <div class='img'>
                  <img src='".url('/').'/resources/assets/uploads/logo/'.getTheCompanyFavicon()."' style='float:left;' width='90' height='90'>
              </div>
                <span style='font-size:25px; font-weight:bold;'>".getTheCompanyName()."</span><br />
                <span style='font-size:15px; font-weight:bold;'>".getTheCompanyAddress()."</span><br />
                <span style='font-size:12px; font-weight:bold;'>".getTheCompanyPhnNo()."</sapn>
              </div>
    <hr>
    </div>
    <div id='footer'>
    <hr>
    <span class='page' style='float:right; font-size:8px;'>Developed By: www.vencerlab.com | 01624823181</span>
    <span class='page'>Page </span>
    </div>
    <div id='content'><h1 class='title'>";
    $htmlData .= session()->get('pdfName');
    $htmlData .= "</h1><table class='table table-striped'>";
    $htmlData .= session()->get('value');

    $htmlData .="</table></div></body</html>";

    $pdf = PDF::loadHtml($htmlData);

    return $pdf->download(session()->get('pdfName').'.pdf');
  }

  public function salePDF(){

    if($_POST['data'])
    {
      $data = $_POST['data'];
      $namePdf = $_POST['pdfName'];
      $invoice = $_POST['invoice'];
      $date = $_POST['date'];
      $customer = $_POST['customer'];

      session(['value' => $data]);
      session(['pdfName' => $namePdf]);
      session(['invoice' => $invoice]);
      session(['date' => $date]);
      session(['customer' => $customer]);
    }
  }


  public function salePrintPdf()
  {
    $htmlData = "
    <html>
    <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js'></script>
        <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
    <style>
    @page{size:auto; margin: 0mm 5mm 0mm 5mm;}
    #header { position: fixed; left: 0px; top: 0px; right: 0px; height: 100px;}
    #footer { position: absolute; right: 0; bottom: 0; left: 0; width: 100%; text-align: center;}
    #footer .page:after { content: counter(page, upper-roman);}
    #content {margin-top:105px; margin-bottom:10px;}
    table{width:95%;}
    .hidden-val{display:none;}
    hr{background-color:black;}
    </style>
    </head>
    <body>
    <div id='header'>

    <div class='companyInfo'>
              <div class='img'>
                  <img src='".url('/').'/resources/assets/uploads/logo/'.getTheCompanyFavicon()."' style='float:left;' width='90' height='90'>
              </div>
                <span style='font-size:25px; font-weight:bold;'>".getTheCompanyName()."</span><br />
                <span style='font-size:15px; font-weight:bold;'>".getTheCompanyAddress()."</span><br />
                <span style='font-size:12px; font-weight:bold;'>".getTheCompanyPhnNo()."</sapn>
              </div>
    <hr>
    </div>
    <div id='footer'>
    <hr>
    <span class='page' style='float:right; font-size:8px;'>Developed By: www.vencerlab.com | 01624823181</span>
    <span class='page'>Page </span>
    </div>
    <div id='content'>";
    $htmlData .= "<span class='pull-right'>";
    $htmlData .= session()->get('date');
    $htmlData .= "</span>";
    $htmlData .= "<span class='pull-left'>";
    $htmlData .= session()->get('invoice');
    $htmlData .= "</span>";
    $htmlData .= "<h3>";
    $htmlData .= session()->get('customer');
    $htmlData .= "</h3>";
    $htmlData .="<table class='table table-striped'>";
    $htmlData .= session()->get('value');

    $htmlData .="</table></div></body</html>";

    $pdf = PDF::loadHtml($htmlData);

    return $pdf->download(session()->get('pdfName').'.pdf');
  }

}
