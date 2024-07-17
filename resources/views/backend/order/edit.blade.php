@extends('admin.layouts.main')

@php $title =  'Order | Admin Panel'; @endphp

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Order</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.order.index') }}">Order</a></li>
                                <li class="breadcrumb-item active">Edit Order</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="position-relative mx-n4 mt-n4">
                <div class="profile-wid-bg profile-setting-img">
                    <img src="{{ URL::asset('/assets') }}/images/profile-bg.jpg" class="profile-wid-img" alt="">
                    <div class="overlay-content">
                        {{-- <div class="text-end p-3">
                        <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                            <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                            <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                                <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                            </label>
                        </div>
                    </div> --}}
                    </div>
                </div>
            </div>

            <div class="row">

                <!--end col-->
                <div class="col-xxl-12">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link text-body active" data-bs-toggle="tab" href="#personalDetails"
                                        role="tab">
                                        <i class="fas fa-home"></i>
                                        Order Details
                                    </a>
                                </li>


                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                    <form action="{{ route('admin.order.update', $order->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" for="product-title-input">Order
                                                                    Id (Optional)</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ old('order_id', $order->order_id) }}"
                                                                    name="order_id" placeholder="Enter Order Id">
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('order_id') }}</div>
                                                            </div>

                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" for="product-title-input">Customer
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ old('customer_name', $order->customer_name) }}"
                                                                    name="customer_name" placeholder="Enter customer name">
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('customer_name') }}</div>
                                                            </div>

                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label" for="product-title-input">Customer
                                                                    Number</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ old('customer_number', $order->customer_contact_number) }}"
                                                                    name="customer_number"
                                                                    placeholder="Enter customer Number">
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('customer_number') }}</div>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" for="product-title-input">Ordered
                                                                    Date</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ old('order_date', $order->ordered_date) }}"
                                                                    name="order_date" placeholder="Enter ordered date"
                                                                    id="nepali-datepicker">
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('order_date') }}</div>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" for="product-title-input">Delivery
                                                                    Address
                                                                </label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ old('delivery_address', $order->delivery_address) }}"
                                                                    name="delivery_address" placeholder="Enter Address">
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('delivery_address') }}</div>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label>Delivery Description</label>

                                                            <textarea class="form-control" rows="4" name="delivery_remarks">{{ old('delivery_remarks', $order->delivery_remarks) }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card -->

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Product Info</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row" id="dynamic-form">
                                                            <div class="table-responsive">
                                                                <table
                                                                    class="invoice-table table table-borderless table-nowrap mb-0">
                                                                    <thead class="align-middle">
                                                                        <tr class="table-active">
                                                                            <th scope="col" style="width: 50px;">#</th>
                                                                            <th scope="col">Product</th>
                                                                            <th scope="col" style="width: 120px;">
                                                                                Measurement</th>
                                                                            <th scope="col" style="width: 120px;">Price
                                                                            </th>
                                                                            <th scope="col" style="width: 120px;">
                                                                                Quantity
                                                                            </th>
                                                                            <th scope="col" class="text-end"
                                                                                style="width: 105px;">
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="followup-details">
                                                                        @php($i = 0);
                                                                        @foreach ($productorders as $prod)
                                                                            @php($i++);

                                                                            <tr class="product">
                                                                                <th scope="row" class="product-id">
                                                                                    {{ $i }}</th>
                                                                                <td class="text-start">
                                                                                    <div class="mb-2">
                                                                                        <select class="form-select select2"
                                                                                            name="product[]" required>
                                                                                            <option value="">Select
                                                                                                Prod.
                                                                                            </option>
                                                                                            @foreach ($products as $product)
                                                                                                <option
                                                                                                    value="{{ $product->id }}"
                                                                                                    {{ $product->id == $prod->product_id ? 'selected' : '' }}>
                                                                                                    {{ $product->name }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>

                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <select class="form-select select2"
                                                                                        name="measurement[]" required>
                                                                                        <option value="">Select
                                                                                            Measu.
                                                                                        </option>
                                                                                        @foreach ($measurements as $measurement)
                                                                                            <option
                                                                                                value="{{ $measurement->id }}"
                                                                                                {{ $measurement->id == $prod->measurement_id ? 'selected' : '' }}>
                                                                                                {{ $measurement->size }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                        <option value="-1"
                                                                                            {{ -1 == $prod->measurement_id ? 'selected' : '' }}>
                                                                                            Others</option>
                                                                                    </select>

                                                                                </td>
                                                                                <td>
                                                                                    <input type="number"
                                                                                        class="form-control"
                                                                                        id="orders-input"
                                                                                        placeholder="price" step="0.01"
                                                                                        name="price[]"
                                                                                        value="{{ $prod->price }}"
                                                                                        required>

                                                                                </td>
                                                                                <td>
                                                                                    <input type="number"
                                                                                        class="form-control"
                                                                                        id="orders-input"
                                                                                        placeholder="Orders"
                                                                                        step="0.01" name="quantity[]"
                                                                                        value="{{ $prod->quantity }}"
                                                                                        required>

                                                                                </td>
                                                                                <td class="product-removal">
                                                                                    <a href="javascript:void(0)"
                                                                                        class="btn btn-success btn-delete">Delete</a>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach

                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" id="add-item"
                                                                                    class="btn btn-soft-secondary fw-medium"><i
                                                                                        class="ri-add-fill me-1 align-bottom"></i>
                                                                                    Add
                                                                                    Item</button>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="3"></td>
                                                                            <td colspan="2">Subtotal:</td>
                                                                            <td id="subtotal">0.00</td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td colspan="3"></td>
                                                                            <td colspan="2">Discount:</td>
                                                                            <td id="discount">
                                                                                <input type="number" class="form-control"
                                                                                    step="0.01" placeholder="discount"
                                                                                    name="discount_amount"
                                                                                    value="{{ $order->discount }}">
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="3"></td>
                                                                            <td colspan="3">
                                                                                <hr>
                                                                            </td>

                                                                        </tr>


                                                                        <tr>
                                                                            <td colspan="3"></td>
                                                                            <td colspan="2">Taxable Amount:</td>
                                                                            <td id="taxable_amount">
                                                                                0.00
                                                                            </td>
                                                                        </tr>



                                                                        <tr>
                                                                            <td colspan="3"></td>
                                                                            <td colspan="2">VAT (13%):</td>
                                                                            <td id="vat">0.00</td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td colspan="3"></td>
                                                                            <td colspan="2">Grand Total:</td>
                                                                            <td id="grand-total">0.00</td>
                                                                        </tr>

                                                                    </tfoot>
                                                                </table>
                                                                <!--end table-->
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">

                                                            <div>
                                                                <label>Customize Order Notes</label>

                                                                <textarea class="form-control" rows="4" id="ckeditor-classic" name="order_notes">{{ old('order_notes', $order->order_notes) }}</textarea>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- end card -->

                                                <div class="card">
                                                    <div class="card-header">
                                                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0"
                                                            role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" data-bs-toggle="tab"
                                                                    href="#addproduct-general-info" role="tab">
                                                                    Payment Details
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-bs-toggle="tab"
                                                                    href="#addproduct-metadata" role="tab">
                                                                    Delivery Details
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- end card header -->
                                                    <div class="card-body">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="addproduct-general-info"
                                                                role="tabpanel">

                                                                <!-- end row -->
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"
                                                                                for="manufacturer-name-input">Total
                                                                                Amount</label>

                                                                            <input type="text" class="form-control"
                                                                                id="manufacturer-name-input"
                                                                                name="total_amount"
                                                                                placeholder="Enter Payment Method"
                                                                                value="{{ old('total_amount') }}">
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"
                                                                                for="manufacturer-name-input">Outstanding/Due
                                                                                Amount</label>

                                                                            <input type="text" class="form-control"
                                                                                id="manufacturer-name-input"
                                                                                name="outstading_amount"
                                                                                placeholder="Enter outstanding amount"
                                                                                value="{{ old('outstading_amount') }}">
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"
                                                                                for="meta-keywords-input">Receivable
                                                                                Amount</label>
                                                                            <input type="text" class="form-control"
                                                                                name="receivable_amount"
                                                                                placeholder="Enter Receivable Amount"
                                                                                id="meta-keywords-input">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"
                                                                                for="manufacturer-name-input">Receivable
                                                                                Payment Method
                                                                            </label>
                                                                            <select class="form-select"
                                                                                id="choices-publish-status-input"
                                                                                name="receivable_payment_method"
                                                                                data-choices data-choices-search-false>
                                                                                <option value="">Select Receivable
                                                                                    Payment Method
                                                                                </option>

                                                                                <option value="Esewa"
                                                                                    {{ old('receivable_payment_method') == 'Esewa' ? 'selected' : '' }}>
                                                                                    Esewa</option>
                                                                                <option value="Khalti"
                                                                                    {{ old('receivable_payment_method') == 'Khalti' ? 'selected' : '' }}>
                                                                                    Khalti
                                                                                </option>
                                                                                <option value="Fonepay"
                                                                                    {{ old('receivable_payment_method') == 'Fonepay' ? 'selected' : '' }}>
                                                                                    Fonepay</option>
                                                                                <option value="Remit"
                                                                                    {{ old('receivable_payment_method') == 'Remit' ? 'selected' : '' }}>
                                                                                    Remit</option>
                                                                                <option value="Cash"
                                                                                    {{ old('receivable_payment_method') == 'Cash' ? 'selected' : '' }}>
                                                                                    Cash</option>
                                                                                <option value="Bank"
                                                                                    {{ old('receivable_payment_method') == 'Bank' ? 'selected' : '' }}>
                                                                                    Bank</option>

                                                                                <option value="Delivery Partner"
                                                                                    {{ old('receivable_payment_method') == 'Delivery Partner' ? 'selected' : '' }}>
                                                                                    Delivery Partner</option>

                                                                            </select>

                                                                        </div>
                                                                    </div>

                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h5 class="card-title mb-0">Payment Receieved
                                                                                Info
                                                                            </h5>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row" id="dynamic-payment-form">
                                                                                <div class="table-responsive">
                                                                                    <table
                                                                                        class="invoice-table table table-borderless table-nowrap mb-0">
                                                                                        <thead class="align-middle">
                                                                                            <tr class="table-active">
                                                                                                <th scope="col"
                                                                                                    style="width: 50px;">#
                                                                                                </th>
                                                                                                <th scope="col">Amount
                                                                                                </th>
                                                                                                <th scope="col"
                                                                                                    style="width: 120px;">
                                                                                                    Payment Method</th>
                                                                                                <th scope="col"
                                                                                                    style="width: 120px;">
                                                                                                    Payment Date
                                                                                                </th>
                                                                                                <th scope="col"
                                                                                                    style="width: 120px;">
                                                                                                    Payment Received By
                                                                                                </th>
                                                                                                <th scope="col"
                                                                                                    style="width: 120px;">
                                                                                                    Is
                                                                                                    Advance
                                                                                                </th>
                                                                                                <th scope="col"
                                                                                                    class="text-end"
                                                                                                    style="width: 105px;">
                                                                                                </th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        @if (isset($orderpayment) && count($orderpayment) > 0)
                                                                                            <tbody id="payment-details">
                                                                                                @php($j = 0);
                                                                                                @foreach ($orderpayment as $payment)
                                                                                                    @php($j++)
                                                                                                    <tr class="product">
                                                                                                        <th scope="row"
                                                                                                            class="payment-id">
                                                                                                            {{ $j }}
                                                                                                        </th>
                                                                                                        <td
                                                                                                            class="text-start">
                                                                                                            <div
                                                                                                                class="mb-2">
                                                                                                                <input
                                                                                                                    type="number"
                                                                                                                    class="form-control"
                                                                                                                    id="amount-input"
                                                                                                                    placeholder="amount"
                                                                                                                    step="0.01"
                                                                                                                    name="amount[]"
                                                                                                                    value="{{ $payment->amount }}">

                                                                                                            </div>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <select
                                                                                                                class="form-select select2"
                                                                                                                name="payment_method[]">
                                                                                                                <option
                                                                                                                    value="">
                                                                                                                    Select
                                                                                                                    Method
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="Esewa"
                                                                                                                    {{ $payment->payment_method == 'Esewa' ? 'selected' : '' }}>
                                                                                                                    Esewa
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="Khalti"
                                                                                                                    {{ $payment->payment_method == 'Khalti' ? 'selected' : '' }}>
                                                                                                                    Khalti
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="Fonepay"
                                                                                                                    {{ $payment->payment_method == 'Fonepay' ? 'selected' : '' }}>
                                                                                                                    Fonepay
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="Remit"
                                                                                                                    {{ $payment->payment_method == 'Remit' ? 'selected' : '' }}>
                                                                                                                    Remit
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="Cash"
                                                                                                                    {{ $payment->payment_method == 'Cash' ? 'selected' : '' }}>
                                                                                                                    Cash
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="Bank"
                                                                                                                    {{ $payment->payment_method == 'Bank' ? 'selected' : '' }}>
                                                                                                                    Bank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="Delivery Partner"
                                                                                                                    {{ $payment->payment_method == 'Delivery Partner' ? 'selected' : '' }}>
                                                                                                                    Delivery
                                                                                                                    Partner
                                                                                                                </option>
                                                                                                            </select>

                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                class="form-control nepali-datepicker"
                                                                                                                name="payment_date[]"
                                                                                                                placeholder="Enter Payment date"
                                                                                                                value="{{ $payment->payment_date }}">

                                                                                                        </td>
                                                                                                        <td>

                                                                                                            <input
                                                                                                                type="text"
                                                                                                                class="form-control"
                                                                                                                id="payment_received_by-input"
                                                                                                                placeholder="payment_received_by"
                                                                                                                name="payment_received_by[]"
                                                                                                                value="{{ $payment->payment_received_by }}">


                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <input
                                                                                                                type="checkbox"
                                                                                                                name="is_advance[]"
                                                                                                                {{ $payment->is_advance == 1 ? 'checked' : '' }}>
                                                                                                        </td>


                                                                                                        <td
                                                                                                            class="payment-removal">
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="btn btn-success btn-delete-pay">Delete</a>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @endforeach
                                                                                            </tbody>
                                                                                        @else
                                                                                            <tbody id="payment-details">

                                                                                                <tr class="product">
                                                                                                    <th scope="row"
                                                                                                        class="payment-id">
                                                                                                        1
                                                                                                    </th>
                                                                                                    <td class="text-start">
                                                                                                        <div
                                                                                                            class="mb-2">
                                                                                                            <input
                                                                                                                type="number"
                                                                                                                class="form-control"
                                                                                                                id="amount-input"
                                                                                                                placeholder="amount"
                                                                                                                step="0.01"
                                                                                                                name="amount[]">

                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <select
                                                                                                            class="form-select select2"
                                                                                                            name="payment_method[]">
                                                                                                            <option
                                                                                                                value="">
                                                                                                                Select
                                                                                                                Method
                                                                                                            </option>
                                                                                                            <option
                                                                                                                value="Esewa">
                                                                                                                Esewa
                                                                                                            </option>
                                                                                                            <option
                                                                                                                value="Khalti">
                                                                                                                Khalti
                                                                                                            </option>
                                                                                                            <option
                                                                                                                value="Fonepay">
                                                                                                                Fonepay
                                                                                                            </option>
                                                                                                            <option
                                                                                                                value="Remit">
                                                                                                                Remit
                                                                                                            </option>
                                                                                                            <option
                                                                                                                value="Cash">
                                                                                                                Cash
                                                                                                            </option>
                                                                                                            <option
                                                                                                                value="Bank">
                                                                                                                Bank
                                                                                                            </option>
                                                                                                            <option
                                                                                                                value="Delivery Partner">
                                                                                                                Delivery
                                                                                                                Partner
                                                                                                            </option>
                                                                                                        </select>

                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            class="form-control nepali-datepicker"
                                                                                                            name="payment_date[]"
                                                                                                            placeholder="Enter Payment date">

                                                                                                    </td>
                                                                                                    <td>

                                                                                                        <input
                                                                                                            type="text"
                                                                                                            class="form-control"
                                                                                                            id="payment_received_by-input"
                                                                                                            placeholder="payment_received_by"
                                                                                                            name="payment_received_by[]">


                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <input
                                                                                                            type="checkbox"
                                                                                                            name="is_advance[]">
                                                                                                    </td>


                                                                                                    <td
                                                                                                        class="payment-removal">
                                                                                                        <a href="javascript:void(0)"
                                                                                                            class="btn btn-success btn-delete-pay">Delete</a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        @endif
                                                                                        <tfoot>
                                                                                            <tr>
                                                                                                <td colspan="5">
                                                                                                    <button type="button"
                                                                                                        id="add-payment"
                                                                                                        class="btn btn-soft-secondary fw-medium"><i
                                                                                                            class="ri-add-fill me-1 align-bottom"></i>
                                                                                                        Add
                                                                                                        Item</button>
                                                                                                </td>
                                                                                            </tr>


                                                                                    </table>
                                                                                    <!--end table-->
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                </div>


                                                                <!-- end row -->
                                                            </div>
                                                            <!-- end tab-pane -->

                                                            <div class="tab-pane" id="addproduct-metadata"
                                                                role="tabpanel">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"
                                                                                for="meta-title-input">Delivery
                                                                                partner</label>
                                                                            <select class="form-select"
                                                                                id="choices-category-inputs"
                                                                                name="delivery_partner" data-choices
                                                                                data-choices-search-false>
                                                                                <option value="">Select Delivery
                                                                                    partner</option>
                                                                                @foreach ($delivery_partners as $partner)
                                                                                    <option value="{{ $partner->id }}"
                                                                                        {{ old('delivery_partner', $order->delivery_partner_id) == $partner->id ? 'selected' : '' }}>
                                                                                        {{ $partner->delivery_company_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end col -->

                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"
                                                                                for="meta-keywords-input">Delivery
                                                                                Date</label>
                                                                            <input type="text" class="form-control"
                                                                                name="delivery_date"
                                                                                placeholder="Enter Delivery Date"
                                                                                id="nepali-datepicker2"
                                                                                value="{{ $order->delivery_date }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"
                                                                                for="meta-keywords-input">Delivery
                                                                                Charge</label>
                                                                            <input type="number" class="form-control"
                                                                                name="delivery_charge"
                                                                                placeholder="Enter Delivery Charge"
                                                                                id="meta-keywords-input"
                                                                                value="{{ $order->delivery_charge }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label"
                                                                                for="meta-keywords-input">Extra
                                                                                Charge</label>
                                                                            <input type="number" class="form-control"
                                                                                name="extra_charge"
                                                                                placeholder="Enter extra Charge"
                                                                                id="meta-keywords-input"
                                                                                value="{{ old('extra_charge', $order->extra_charge) }}">
                                                                        </div>
                                                                    </div>


                                                                    <!-- end col -->
                                                                </div>
                                                                <!-- end row -->


                                                            </div>
                                                            <!-- end tab pane -->
                                                        </div>
                                                        <!-- end tab content -->
                                                    </div>
                                                    <!-- end card body -->
                                                </div>
                                                <!-- end card -->
                                                <div class="text-end mb-3">
                                                    <button type="submit" class="btn btn-success w-sm">Submit</button>
                                                </div>
                                            </div>
                                            <!-- end col -->

                                            <div class="col-lg-4">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Priority Management</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label for="choices-publish-status-input"
                                                                class="form-label">Status</label>

                                                            <select class="form-select" id="choices-publish-status-input"
                                                                name="status" data-choices data-choices-search-false>
                                                                <option value="">Select Status</option>
                                                                <option value="Hold"
                                                                    {{ old('status', $order->status) == 'Hold' ? 'selected' : '' }}>
                                                                    Hold</option>
                                                                <option value="Inprogress"
                                                                    {{ old('status', $order->status) == 'Inprogress' ? 'selected' : '' }}>
                                                                    Inprogress</option>
                                                                <option value="Pending"
                                                                    {{ old('status', $order->status) == 'Pending' ? 'selected' : '' }}>
                                                                    Pending
                                                                </option>
                                                                <option value="Delivered"
                                                                    {{ old('status', $order->status) == 'Delivered' ? 'selected' : '' }}>
                                                                    Delivered</option>
                                                                <option value="Cancelled"
                                                                    {{ old('status', $order->status) == 'Cancelled' ? 'selected' : '' }}>
                                                                    Cancelled</option>
                                                                <option value="Returned"
                                                                    {{ old('status', $order->status) == 'Returned' ? 'selected' : '' }}>
                                                                    Returned</option>
                                                                <option value="Completed"
                                                                    {{ old('status', $order->status) == 'Completed' ? 'selected' : '' }}>
                                                                    Completed</option>

                                                            </select>
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('status') }}
                                                            </div>

                                                        </div>

                                                        <div>
                                                            <label for="choices-publish-visibility-input"
                                                                class="form-label">Priority</label>
                                                            <select class="form-select"
                                                                id="choices-publish-visibility-input" name="priority"
                                                                data-choices data-choices-search-false>
                                                                <option value="">Select Priority</option>
                                                                <option value="High"
                                                                    {{ old('priority', $order->priority) == 'High' ? 'selected' : '' }}>
                                                                    High
                                                                </option>
                                                                <option value="Medium"
                                                                    {{ old('priority', $order->priority) == 'Medium' ? 'selected' : '' }}>
                                                                    Medium
                                                                </option>
                                                                <option value="Low"
                                                                    {{ old('priority', $order->priority) == 'Low' ? 'selected' : '' }}>
                                                                    Low
                                                                </option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('priority') }}
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- end card body -->
                                                </div>
                                                <!-- end card -->



                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Product Handled By</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="text-muted mb-2"> Select product handled by</p>
                                                        <select class="form-select" id="choices-category-input"
                                                            name="product_handled_by" data-choices
                                                            data-choices-search-false>
                                                            <option value="">Select Trailer</option>
                                                            @foreach ($trailers as $trailer)
                                                                <option value="{{ $trailer->id }}"
                                                                    {{ old('product_handled_by', $order->handled_by) == $trailer->id ? 'selected' : '' }}>
                                                                    {{ $trailer->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('product_handled_by') }}
                                                        </div>

                                                    </div>
                                                    <!-- end card body -->
                                                </div>


                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>


                                <!--end tab-pane-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>

        </div>
        <!-- container-fluid -->
    </div>
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            width: 150px;
        }
    </style>
    <link href="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/css/nepali.datepicker.v4.0.1.min.css"
        rel="stylesheet" type="text/css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.1.min.js"
        type="text/javascript"></script>
    <script type="text/javascript">
        window.onload = function() {
            var mainInput = document.getElementById("nepali-datepicker");
            mainInput.nepaliDatePicker();

            // var mainInput1 = document.getElementById("nepali-datepicker1");
            // mainInput1.nepaliDatePicker();

            var mainInput2 = document.getElementById("nepali-datepicker2");
            mainInput2.nepaliDatePicker();

            $('.nepali-datepicker').nepaliDatePicker();

        };
    </script>

    <script>
        function addNewItem() {
            var $products = <?php echo json_encode($products); ?>;
            var $measurements = <?php echo json_encode($measurements); ?>;
            var table = document.getElementById('followup-details');
            var newRow = table.insertRow();
            newRow.className = 'product';

            var cellId = newRow.insertCell(0);
            cellId.className = 'product-id';
            cellId.textContent = table.rows.length;

            var cellProduct = newRow.insertCell(1);
            var productSelect = document.createElement('select');
            productSelect.className = 'form-select select2';
            productSelect.setAttribute('name', 'product[]');
            productSelect.setAttribute('required', 'true'); // Add required attribute
            var productOption = document.createElement('option');
            productOption.value = '';
            productOption.textContent = 'Select Prod.';
            productSelect.appendChild(productOption);
            // Assuming $products is a JavaScript array defined somewhere in your code
            $products.forEach(function(product) {
                var option = document.createElement('option');
                option.value = product.id;
                option.textContent = product.name;
                productSelect.appendChild(option);
            });
            cellProduct.appendChild(productSelect);

            var cellMeasurement = newRow.insertCell(2);
            var measurementSelect = document.createElement('select');
            measurementSelect.className = 'form-select select2';
            measurementSelect.setAttribute('name', 'measurement[]');
            measurementSelect.setAttribute('required', 'true'); // Add required attribute
            var measurementOption = document.createElement('option');
            measurementOption.value = '';
            measurementOption.textContent = 'Select Measu.';
            measurementSelect.appendChild(measurementOption);
            // Assuming $measurements is a JavaScript array defined somewhere in your code
            $measurements.forEach(function(measurement) {
                var option = document.createElement('option');
                option.value = measurement.id;
                option.textContent = measurement.size;
                measurementSelect.appendChild(option);
            });
            var othersOption = document.createElement('option');
            othersOption.value = '-1';
            othersOption.textContent = 'Others';
            measurementSelect.appendChild(othersOption);
            cellMeasurement.appendChild(measurementSelect);

            var cellPrice = newRow.insertCell(3);
            var priceInput = document.createElement('input');
            priceInput.type = 'number';
            priceInput.className = 'form-control';
            priceInput.id = 'orders-input';
            priceInput.placeholder = 'Price';
            priceInput.step = '0.01';
            priceInput.name = 'price[]';
            priceInput.required = true;
            priceInput.value = '';
            cellPrice.appendChild(priceInput);

            var cellQuantity = newRow.insertCell(4);
            var quantityInput = document.createElement('input');
            quantityInput.type = 'number';
            quantityInput.className = 'form-control';
            quantityInput.id = 'orders-input';
            quantityInput.placeholder = 'Orders';
            quantityInput.step = '1';
            quantityInput.name = 'quantity[]';
            quantityInput.required = true;
            quantityInput.value = '';
            cellQuantity.appendChild(quantityInput);

            var cellRemoval = newRow.insertCell(5);
            var deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'btn btn-success btn-delete';
            deleteButton.textContent = 'Delete';
            deleteButton.addEventListener('click', function() {
                deleteRow(newRow);
            });
            cellRemoval.appendChild(deleteButton);
            $('.select2').select2();

        }

        document.getElementById('add-item').addEventListener('click', function() {
            addNewItem();
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener to the "Add Item" button

            // Add event listener to the "Delete" buttons
            var deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    deleteRow(button.closest(
                        'tr'
                    )); // Find the closest <tr> element and pass it to the deleteRow function
                });
            });
        });

        function calcualteadv() {
            var advances = document.getElementsByName("amount[]");
            var totalAdvance = 0;
            for (var i = 0; i < advances.length; i++) {
                var advance = parseFloat(advances[i].value);
                if (!isNaN(advance)) {
                    totalAdvance += advance;
                }
            }

            var total = parseFloat(document.getElementsByName("total_amount")[0].value);
            if (!isNaN(total) && !isNaN(totalAdvance)) {
                var out = total - totalAdvance;
                document.getElementsByName("outstading_amount")[0].value = out.toFixed(2);
            }
        }

        function calculateTotal() {
            var total = 0;
            $('tr.product').each(function() {
                var quantity = $(this).find('input[name="quantity[]"]').val();
                var price = $(this).find('input[name="price[]"]').val();
                if (quantity && price) {
                    total += quantity * price;
                }
            });
            var discount = $('input[name="discount_amount"]').val();
            var tax_discountdiscout = discount ? discount / 1.13 : discount;

            var vatRate = 0.13; // 13% VAT rate
            var vat = total * vatRate;
            var subtotal = total / 1.13;
            var discounttotal = subtotal - tax_discountdiscout;
            var main_vat = discounttotal * vatRate;
            var grandtotal = discounttotal + main_vat;
            $('#taxable_amount').text(discounttotal.toFixed(2));
            $('#subtotal').text(subtotal.toFixed(2));
            $('#vat').text(main_vat.toFixed(2));
            $('#grand-total').text(grandtotal.toFixed(2));
            $('[name="total_amount"]').val(grandtotal.toFixed(2));
            calcualteadv();
        }

        function deleteRow(row) {
            row.parentNode.removeChild(row); // Remove the row from its parent node (the <tbody>)
            calculateTotal();

        }
    </script>
    <script>
        $(document).ready(function() {
            calculateTotal();
            $(document).on('change', 'select[name="product[]"]', function() {
                var product = $(this).val();
                var $row = $(this).closest('.product');
                if (product) {
                    $.ajax({
                        url: '/admin/order/product/' + product,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $row.find('[name="price[]"]').val(data.data);
                            calculateTotal();
                        }
                    });
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('blur', 'input[name="quantity[]"]', function() {
                var total = 0;
                $('tr.product').each(function() {
                    var quantity = $(this).find('input[name="quantity[]"]').val();
                    var price = $(this).find('input[name="price[]"]').val();
                    if (quantity && price) {
                        total += quantity * price;
                    }
                });
                var discount = $('input[name="discount_amount"]').val();
                var tax_discountdiscout = discount ? discount / 1.13 : discount;

                var vatRate = 0.13; // 13% VAT rate
                var vat = total * vatRate;
                var subtotal = total / 1.13;
                var discounttotal = subtotal - tax_discountdiscout;
                var main_vat = discounttotal * vatRate;
                var grandtotal = discounttotal + main_vat;
                $('#taxable_amount').text(discounttotal.toFixed(2));
                $('#subtotal').text(subtotal.toFixed(2));
                $('#vat').text(main_vat.toFixed(2));
                $('#grand-total').text(grandtotal.toFixed(2));
                $('[name="total_amount"]').val(grandtotal.toFixed(2));
                calcualteadv();
            });
            $('[name="discount_amount"]').blur(function() {
                calculateTotal();
            });

            $(document).on('blur', 'input[name="amount[]"]', function() {
                var totalAdvance = 0;
                $('[name="amount[]"]').each(function() {
                    var advance = parseFloat($(this).val());
                    if (!isNaN(advance)) {
                        totalAdvance += advance;
                    }
                });

                var total = parseFloat($('[name="total_amount"]').val());
                if (!isNaN(total) && !isNaN(totalAdvance)) {
                    var out = total - totalAdvance;
                    $('[name="outstading_amount"]').val(out.toFixed(2));
                }
            });


        });
    </script>
    <script>
        function addPaymentItem() {
            var orderPayments = <?php echo json_encode($orderpayment); ?>;
            var paymentDetails = document.getElementById('payment-details');
            var newRow = document.createElement('tr');
            newRow.className = 'product';

            // Create and append cells for each payment detail
            var cellId = document.createElement('th');
            cellId.className = 'payment-id';
            cellId.scope = 'row';
            cellId.textContent = paymentDetails.rows.length + 1;
            newRow.appendChild(cellId);

            var cellAmount = document.createElement('td');
            var amountInput = document.createElement('input');
            amountInput.type = 'number';
            amountInput.className = 'form-control';
            amountInput.id = 'amount-input';
            amountInput.placeholder = 'amount';
            amountInput.step = '0.01';
            amountInput.name = 'amount[]';
            amountInput.value = '';
            cellAmount.appendChild(amountInput);
            newRow.appendChild(cellAmount);

            var cellMethod = document.createElement('td');
            var methodSelect = document.createElement('select');
            methodSelect.className = 'form-select select2';
            methodSelect.setAttribute('name', 'payment_method[]');
            // Add options for payment methods
            var methods = ['Esewa', 'Khalti', 'Fonepay', 'Remit', 'Cash', 'Bank', 'Delivery Partner'];
            methods.forEach(function(method) {
                var option = document.createElement('option');
                option.value = method;
                option.textContent = method;
                methodSelect.appendChild(option);
            });
            cellMethod.appendChild(methodSelect);
            newRow.appendChild(cellMethod);

            var cellDate = document.createElement('td');
            var dateInput = document.createElement('input');
            dateInput.type = 'text';
            dateInput.className = 'form-control nepali-datepicker';
            dateInput.name = 'payment_date[]';
            dateInput.placeholder = 'Enter Payment date';
            dateInput.value = '';
            cellDate.appendChild(dateInput);
            newRow.appendChild(cellDate);

            var cellReceivedBy = document.createElement('td');
            var receivedByInput = document.createElement('input');
            receivedByInput.type = 'text';
            receivedByInput.className = 'form-control';
            receivedByInput.id = 'payment_received_by-input';
            receivedByInput.placeholder = 'Payment Received By';
            receivedByInput.name = 'payment_received_by[]';
            receivedByInput.value = '';
            cellReceivedBy.appendChild(receivedByInput);
            newRow.appendChild(cellReceivedBy);

            var cellAdvance = document.createElement('td');
            var advanceCheckbox = document.createElement('input');
            advanceCheckbox.type = 'checkbox';
            advanceCheckbox.name = 'is_advance[]';
            cellAdvance.appendChild(advanceCheckbox);
            newRow.appendChild(cellAdvance);

            var cellRemoval = document.createElement('td');
            var deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'btn btn-success btn-delete-pay';
            deleteButton.textContent = 'Delete';
            deleteButton.addEventListener('click', function() {
                deleteRow1(newRow);
            });
            cellRemoval.appendChild(deleteButton);
            newRow.appendChild(cellRemoval);

            // Append the new row to the payment details table
            paymentDetails.appendChild(newRow);

            $('.select2').select2();
            $('.nepali-datepicker').nepaliDatePicker();
        }

        // Function to delete a row
        function deleteRow1(row) {
            row.parentNode.removeChild(row);
            calcualteadv();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener to the "Add Item" button
            document.getElementById('add-payment').addEventListener('click', function() {
                addPaymentItem();
            });

            // Add event listener to the "Delete" buttons
            var deleteButtonspay = document.querySelectorAll('.btn-delete-pay');
            deleteButtonspay.forEach(function(button) {
                button.addEventListener('click', function() {
                    deleteRow1(button.closest('tr'));

                });

            });


        });
    </script>

    <script src="{{ URL::asset('/assets') }}/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>


    <script>
        var ckeditorClassic = document.querySelector('#ckeditor-classic');
        if (ckeditorClassic) {
            ClassicEditor
                .create(document.querySelector('#ckeditor-classic'))
                .then(function(editor) {
                    editor.ui.view.editable.element.style.height = '200px';
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
    </script>
@endsection
