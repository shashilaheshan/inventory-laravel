<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/storeclose','StoreController@index' );
Route::post('/changeStoreClose', 'StoreController@changeStoreClose');
Route::post('/changeStoreOpen', 'StoreController@changeStoreOpen');

Route::get('/home', 'HomeController@index');
Route::get('/profile', 'HomeController@profile');
Route::post('/profile_edit', 'HomeController@profile_edit');
Route::post('/password_change', 'HomeController@password_change');

Route::get('/products', 'ProductController@index');
Route::post('/addProduct', 'ProductController@addProduct');
Route::get('/alert', 'ProductController@alertProducts');
Route::post('/changeAlertQuanityAndUnitPrice', 'ProductController@changeAlertQuanityAndUnitPrice');

Route::get('/customers', 'CustomerController@index');
Route::post('/addCustomer','CustomerController@addCustomer');
Route::post('/addCustomerFromInvoice','CustomerController@addCustomerFromInvoice');
Route::post('/updateCustomer','CustomerController@updateCustomer');
Route::post('/updateCustomerSoftStatus','CustomerController@updateCustomerSoftStatus');

Route::get('/invoice', 'InvoiceController@index');

Route::get('/expense', 'ExpenseController@index');
Route::post('/addExpense', 'ExpenseController@addExpense');
Route::post('/addExpenseCategory', 'ExpenseController@addExpenseCategory');
Route::post('/editExpenseCategory', 'ExpenseController@editExpenseCategory');

Route::get('/vendors', 'VendorController@index');
Route::post('/addVendor', 'VendorController@addVendor');
Route::post('/updateVendor', 'VendorController@updateVendor');
Route::post('/updateSoftStatus', 'VendorController@updateSoftStatus');
Route::get('/vendorledger', 'VendorController@vendorLedger');
Route::get('/vendorledger/{vendor_id}','VendorController@vendorLedgerdetails');
Route::post('/updateVendorPayment', 'VendorController@updateVendorPayment');
Route::get('/purchasereport','VendorController@purchasereport');

Route::get('/humanresource','HumanResourceController@index');
Route::post('/inserthr','HumanResourceController@insertHr');
Route::post('/deleteStaff', 'HumanResourceController@deleteStaff');
Route::post('/editStaffInformation', 'HumanResourceController@editStaffInformation');
Route::get('/userlist', 'HumanResourceController@userList');
Route::get('/deleteuser/{id}', 'HumanResourceController@deleteUser');

Route::post('/expensepdf','PdfController@expensePDF');
Route::get('/printpdf','PdfController@printPdf');
Route::post('/salepdf','PdfController@salePDF');
Route::get('/saleprintpdf','PdfController@salePrintPdf');


Route::get('/inventories','InventoriesController@index');
Route::post('/addQuantity','InventoriesController@addQuantity');
Route::post('/productlist','InventoriesController@productList');

Route::get('/settings', 'SettingController@index');
Route::post('/editCompanyInformation','SettingController@editCompanyInformation');

Route::get('/sale','SaleController@index');
Route::get('/sale/{invoice_id}','SaleController@saleDetails');


Route::get('/customerledger','C_transectionController@index');
Route::get('/customerledger/{customer_id}','C_transectionController@customerLedgerDetails');
Route::post('/updateCustomerPayment','C_transectionController@updateCustomerPayment');

Route::post('/inventoriesdata','InvoiceController@inventoriesData');
Route::post('/customerdata','InvoiceController@customerData');
Route::post('/tempsales','InvoiceController@tempSales');
Route::post('/postsale','InvoiceController@postsale');
Route::get('/deletetemp','InvoiceController@deleteTemp');
Route::post('/delsalerow','InvoiceController@delSaleRow');


Route::post('/damagelist','DamageController@damageList');
Route::post('/damageissue','DamageController@damageIssue');
Route::get('/damages','DamageController@index');



Route::get('/restore','RestoreController@index');
Route::post('/restoreVendor','RestoreController@restoreVendor');
Route::post('/restoreCustomer','RestoreController@restoreCustomer');

Route::get('/pendinginvoice','PendinginvoiceController@index');
Route::post('/releasependinginvoice','PendinginvoiceController@releasePendingInvoice');

Route::get('/categories','CategoryController@index');
Route::post('/addCategory','CategoryController@addCategory');
Route::post('/deleteCategory','CategoryController@deleteCategory');
