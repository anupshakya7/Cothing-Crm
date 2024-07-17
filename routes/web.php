<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CategoryItemController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeliveryPartnerController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ItemsController;
use App\Http\Controllers\Admin\MeasurementController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PatternController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\SupplierOrderController;
use App\Http\Controllers\Admin\TrailerController;
use App\Http\Controllers\Admin\VendorsController;
use App\Http\Controllers\Admin\VendorPaymentController;
use pp\Http\Controllers\Admin\SuppliersOrder;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::redirect('/home', '/admin', 301);
Route::get('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('admin/login');
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('dashboard');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
    // Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::get('/users/profile', [UsersController::class, 'profile'])->name('users.profile');
    Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/update/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [UsersController::class, 'destroy'])->name('users.delete');

    //for Category Items
    Route::get('/items-category', [CategoryItemController::class, 'index'])->name('items-category.index');
    Route::get('/items-category/create', [CategoryItemController::class, 'create'])->name('items-category.create');
    Route::post('/items-category/store', [CategoryItemController::class, 'store'])->name('items-category.store');
    Route::get('/items-category/edit/{id}/{type}', [CategoryItemController::class, 'edit'])->name('items-category.edit');
    Route::put('/items-category/update/{id}', [CategoryItemController::class, 'update'])->name('items-category.update');
    Route::delete('/items-category/delete/{id}/{type}', [CategoryItemController::class, 'destroy'])->name('items-category.delete');

    //for Items
    Route::get('/items', [ItemsController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemsController::class, 'create'])->name('items.create');
    Route::post('/items/store', [ItemsController::class, 'store'])->name('items.store');
    Route::get('/items/edit/{id}', [ItemsController::class, 'edit'])->name('items.edit');
    Route::put('/items/update/{id}', [ItemsController::class, 'update'])->name('items.update');
    Route::delete('/items/delete/{id}', [ItemsController::class, 'destroy'])->name('items.delete');

    //for vendor
    Route::get('/vendors', [VendorsController::class, 'index'])->name('vendors.index');
    Route::get('/vendors/create', [VendorsController::class, 'create'])->name('vendors.create');
    Route::post('/vendors/store', [VendorsController::class, 'store'])->name('vendors.store');
    Route::get('/vendors/edit/{id}', [VendorsController::class, 'edit'])->name('vendors.edit');
    Route::put('/vendors/update/{id}', [VendorsController::class, 'update'])->name('vendors.update');
    Route::delete('/vendors/delete/{id}', [VendorsController::class, 'destroy'])->name('vendors.delete');

    //for supply orders
    Route::get('/suppliers', [SupplierOrderController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [SupplierOrderController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers/store', [SupplierOrderController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/detail', [SupplierOrderController::class, 'detail'])->name('suppliers.detail');
    Route::get('/suppliers/edit/{id}', [SupplierOrderController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/update/{id}', [SupplierOrderController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/delete/{id}', [SupplierOrderController::class, 'destroy'])->name('suppliers.delete');
    Route::delete('/suppliers/delete-all/{vendor_id}', [SupplierOrderController::class, 'destroyAll'])->name('suppliers.delete.all');
    Route::get('/suppliers/category-subcategory/{category}',[SupplierOrderController::class,'categorySubCategory'])->name('suppliers.categorySubCategory');
    Route::get('/suppliers/category-items/{category}',[SupplierOrderController::class,'categoryItems'])->name('suppliers.categoryItems');

    //for Vendor Payment
    Route::get('/vendors-payment', [VendorPaymentController::class, 'index'])->name('vendors-payment.index');
    Route::get('/vendors-payment/create', [VendorPaymentController::class, 'create'])->name('vendors-payment.create');
    Route::post('/vendors-payment/store', [VendorPaymentController::class, 'store'])->name('vendors-payment.store');
    Route::get('/vendors-payment/detail/{vendor_id}',[VendorPaymentController::class,'detail'])->name('vendors-payment.detail');
    Route::get('/vendors-payment/edit/{id}', [VendorPaymentController::class, 'edit'])->name('vendors-payment.edit');
    Route::put('/vendors-payment/update/{id}', [VendorPaymentController::class, 'update'])->name('vendors-payment.update');
    Route::delete('/vendors-payment/delete/{id}', [VendorPaymentController::class, 'destroy'])->name('vendors-payment.delete');
    Route::delete('/vendors-payment/delete-all/{vendor_id}', [VendorPaymentController::class, 'destroyAll'])->name('vendors-payment.delete.all');

    //for category
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}/{type}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
    Route::get('/category/maincategory/{category}', [CategoryController::class, 'maincategory'])->name('category.maincategory');

    //for Pattern
    Route::get('/pattern', [PatternController::class, 'index'])->name('pattern.index');
    Route::get('/pattern/create', [PatternController::class, 'create'])->name('pattern.create');
    Route::post('/pattern/store', [PatternController::class, 'store'])->name('pattern.store');
    Route::get('/pattern/edit/{id}', [PatternController::class, 'edit'])->name('pattern.edit');
    Route::put('/pattern/update/{id}', [PatternController::class, 'update'])->name('pattern.update');
    Route::delete('/pattern/delete/{id}', [PatternController::class, 'destroy'])->name('pattern.delete');
    Route::get('/pattern/sizes/{category}', [PatternController::class, 'sizes'])->name('pattern.sizes');


    //for measurement
    Route::get('/measurement', [MeasurementController::class, 'index'])->name('measurement.index');
    Route::get('/measurement/create', [MeasurementController::class, 'create'])->name('measurement.create');
    Route::post('/measurement/store', [MeasurementController::class, 'store'])->name('measurement.store');
    Route::get('/measurement/edit/{id}', [MeasurementController::class, 'edit'])->name('measurement.edit');
    Route::put('/measurement/update/{id}', [MeasurementController::class, 'update'])->name('measurement.update');
    Route::delete('/measurement/delete/{id}', [MeasurementController::class, 'destroy'])->name('measurement.delete');

    //for product
    Route::get('/product', [ProductsController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductsController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductsController::class, 'store'])->name('product.store');
    Route::get('/product/edit/{id}', [ProductsController::class, 'edit'])->name('product.edit');
    Route::put('/product/update/{id}', [ProductsController::class, 'update'])->name('product.update');
    Route::delete('/product/delete/{id}', [ProductsController::class, 'destroy'])->name('product.delete');

    //for Enquiry
    Route::get('/enquiry', [EnquiryController::class, 'index'])->name('enquiry.index');
    Route::get('/enquiry/create', [EnquiryController::class, 'create'])->name('enquiry.create');
    Route::post('/enquiry/store', [EnquiryController::class, 'store'])->name('enquiry.store');
    Route::get('/enquiry/edit/{id}', [EnquiryController::class, 'edit'])->name('enquiry.edit');
    Route::put('/enquiry/update/{id}', [EnquiryController::class, 'update'])->name('enquiry.update');
    Route::delete('/enquiry/delete/{id}', [EnquiryController::class, 'destroy'])->name('enquiry.delete');
    Route::get('/enquiry/followup/{id}', [EnquiryController::class, 'followup'])->name('enquiry.followup');
    Route::get('/enquiry/customer/{id}', [EnquiryController::class, 'customer'])->name('enquiry.customer');
    Route::post('/enquiry/orderstore', [EnquiryController::class, 'orderstore'])->name('enquiry.orderstore');

    //for Trailer
    Route::get('/trailer', [TrailerController::class, 'index'])->name('trailer.index');
    Route::get('/trailer/create', [TrailerController::class, 'create'])->name('trailer.create');
    Route::post('/trailer/store', [TrailerController::class, 'store'])->name('trailer.store');
    Route::get('/trailer/edit/{id}', [TrailerController::class, 'edit'])->name('trailer.edit');
    Route::put('/trailer/update/{id}', [TrailerController::class, 'update'])->name('trailer.update');
    Route::delete('/trailer/delete/{id}', [TrailerController::class, 'destroy'])->name('trailer.delete');

    //for order
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/report', [OrderController::class, 'report'])->name('order.report');
    Route::get('/order/daily', [OrderController::class, 'daily'])->name('order.daily');
    Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
    Route::put('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/order/delete/{id}', [OrderController::class, 'destroy'])->name('order.delete');
    Route::get('/order/fetchcustomerdata', [OrderController::class, 'fetchCustomerData'])->name('order.fetchcustomerdata');
    Route::get('/order/order-list-pdf', [OrderController::class, 'generateOrderListPDF'])->name('order.order-list-pdf');
    Route::get('/order/product/{id}', [OrderController::class, 'product'])->name('order.product');
    Route::get('/order/order-invoice/{id}', [OrderController::class, 'generateOrderInvoice'])->name('order.order-invoice');
    Route::get('/order/transfer-order', [OrderController::class, 'TransferOrder'])->name('order.transfer-order');
    Route::post('/order/print', [OrderController::class, 'print'])->name('order.print');

    //for customer
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/delete/{id}', [CustomerController::class, 'destroy'])->name('customer.delete');


    //for delivery
    Route::get('/delivery', [DeliveryPartnerController::class, 'index'])->name('delivery.index');
    Route::get('/delivery/create', [DeliveryPartnerController::class, 'create'])->name('delivery.create');
    Route::post('/delivery/store', [DeliveryPartnerController::class, 'store'])->name('delivery.store');
    Route::get('/delivery/edit/{id}', [DeliveryPartnerController::class, 'edit'])->name('delivery.edit');
    Route::put('/delivery/update/{id}', [DeliveryPartnerController::class, 'update'])->name('delivery.update');
    Route::delete('/delivery/delete/{id}', [DeliveryPartnerController::class, 'destroy'])->name('delivery.delete');
});
