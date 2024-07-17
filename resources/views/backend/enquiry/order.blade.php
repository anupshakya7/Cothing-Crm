@extends('admin.layouts.main')

@php $title =  'Enquiry Orders Create | Admin Panel'; @endphp

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Enquiry </h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.enquiry.index') }}">Orders</a></li>
                                <li class="breadcrumb-item active">Create Enquiry Order</li>
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

                <!--end card-->

                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-xxl-12">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-body active" data-bs-toggle="tab" href="#personalDetails"
                                    role="tab">
                                    <i class="fas fa-home"></i>
                                    Enquiry Orders Details
                                </a>
                            </li>

                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form action="{{ route('admin.enquiry.orderstore') }}" method="POST" enctype="multipart/form-data"
                                    autocomplete="false">
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="product-title-input">Customer
                                                                Number</label>
                                                            <input type="text" class="form-control"
                                                                id="product-title-input"
                                                                value="{{ old('customer_number',$enquiry->mobile) }}" name="customer_number"
                                                                placeholder="Enter customer Number" readonly>
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('customer_number') }}</div>
                                                        </div>


                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="product-title-input">Customer
                                                                Name</label>
                                                            <input type="text" class="form-control"
                                                                id="product-title-input" value="{{ old('customer_name',$enquiry->name) }}"
                                                                name="customer_name" placeholder="Enter customer name" readonly>
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('customer_name') }}</div>
                                                        </div>


                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="product-title-input">Delivery
                                                                Address
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                id="product-title-input"
                                                                value="{{ old('delivery_address') }}"
                                                                name="delivery_address" placeholder="Enter Address">
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('delivery_address') }}</div>
                                                        </div>


                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="order-nepali-date">Ordered
                                                                Date</label>
                                                            <input type="text" class="form-control"
                                                                id="order-nepali-date" value="{{ old('order_date') }}"
                                                                name="order_date" placeholder="Enter ordered date">
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('order_date') }}</div>
                                                        </div>


                                                    </div>

                                                    <div>
                                                        <label>Delivery Description</label>

                                                        <textarea class="form-control" rows="4" name="delivery_remarks">{{ old('delivery_remarks') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card -->

                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">Product Info</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label for="skillsInput" class="form-label">Product</label>
                                                                <select class="form-select" data-choices
                                                                    data-choices-search-false name="product">
                                                                    <option value="">Select Product</option>
                                                                    @foreach ($products as $product)
                                                                        <option value="{{ $product->id }}">
                                                                            {{ $product->name }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>

                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('product') }}
                                                                </div>


                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label for="skillsInput"
                                                                    class="form-label">Measurement</label>
                                                                <select class="form-select" name="measurement"
                                                                    data-choices data-choices-search-false
                                                                    name="choices-single-default2">
                                                                    <option value="">Select Measurement</option>
                                                                    @foreach ($measurements as $measurement)
                                                                        <option value="{{ $measurement->id }}"
                                                                            {{ $measurement->id == old('measurement') ? 'selected' : '' }}>
                                                                            {{ $measurement->size }}</option>
                                                                    @endforeach
                                                                    <option value="-1"
                                                                        {{ -1 == old('measurement') ? 'selected' : '' }}>
                                                                        Others</option>

                                                                </select>

                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('measurement') }}
                                                                </div>


                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-sm-4">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="orders-input">Quantity</label>
                                                                <input type="number" class="form-control"
                                                                    id="orders-input" placeholder="Orders" step="0.01"
                                                                    name="quantity" value="{{ old('quantity') }}">
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('quantity') }}</div>

                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label>Customize Order Notes</label>

                                                            <textarea class="form-control" rows="4" name="order_notes">{{ old('order_notes') }}</textarea>
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
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="manufacturer-name-input">Payment
                                                                            Method</label>
                                                                        <input type="text" class="form-control"
                                                                            id="manufacturer-name-input"
                                                                            name="payment_method"
                                                                            placeholder="Enter Payment Method"
                                                                            value="{{ old('payment_method') }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="manufacturer-name-input">Advance</label>
                                                                        <input type="number" class="form-control"
                                                                            id="manufacturer-name-input" name="advance"
                                                                            placeholder="Enter Payment advance"
                                                                            value="{{ old('advance') }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="payment-nepali-date">Payment
                                                                            Date</label>
                                                                        <input type="text" class="form-control"
                                                                            id="payment-nepali-date"
                                                                            name="payment_date"
                                                                            placeholder="Enter Payment date"
                                                                            value="{{ old('payment_date') }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="manufacturer-brand-input">Payment Received
                                                                            By</label>
                                                                        <input type="text" class="form-control"
                                                                            id="manufacturer-brand-input"
                                                                            name="payment_status"
                                                                            placeholder="Enter received by"
                                                                            value="{{ old('payment_status') }}">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!-- end row -->


                                                            <!-- end row -->
                                                        </div>
                                                        <!-- end tab-pane -->

                                                        <div class="tab-pane" id="addproduct-metadata" role="tabpanel">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="meta-title-input">Delivery partner</label>
                                                                        <select class="form-select"
                                                                            id="choices-category-inputs"
                                                                            name="delivery_partner" data-choices
                                                                            data-choices-search-false>
                                                                            <option value="">Select Delivery partner
                                                                            </option>
                                                                            @foreach ($delivery_partners as $partner)
                                                                                <option value="{{ $partner->id }}"
                                                                                    {{ old('delivery_partner') == $partner->id ? 'selected' : '' }}>
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
                                                                            for="delivery-nepali-date">Delivery Date</label>
                                                                        <input type="text" class="form-control"
                                                                            name="delivery_date"
                                                                            placeholder="Enter Delivery Date"
                                                                            id="delivery-nepali-date">
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
                                                                            id="meta-keywords-input">
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

                                                            <option value="Inprogress"
                                                                {{ old('status') == 'Inprogress' ? 'selected' : '' }}>
                                                                Inprogress</option>
                                                            <option value="Pending"
                                                                {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending
                                                            </option>
                                                            <option value="Delivered"
                                                                {{ old('status') == 'Delivered' ? 'selected' : '' }}>
                                                                Delivered</option>
                                                            <option value="Cancelled"
                                                                {{ old('status') == 'Cancelled' ? 'selected' : '' }}>
                                                                Cancelled</option>
                                                            <option value="Returned"
                                                                {{ old('status') == 'Returned' ? 'selected' : '' }}>
                                                                Returned</option>
                                                                <option value="Completed"
                                                                {{ old('status') == 'Completed' ? 'selected' : '' }}>
                                                                Completed</option>

                                                        </select>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('status') }}
                                                        </div>

                                                    </div>

                                                    <div>
                                                        <label for="choices-publish-visibility-input"
                                                            class="form-label">Priority</label>
                                                        <select class="form-select" id="choices-publish-visibility-input"
                                                            name="priority" data-choices data-choices-search-false>
                                                            <option value="">Select Priority</option>
                                                            <option value="High"
                                                                {{ old('priority') == 'High' ? 'selected' : '' }}>High
                                                            </option>
                                                            <option value="Medium"
                                                                {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium
                                                            </option>
                                                            <option value="Low"
                                                                {{ old('priority') == 'Low' ? 'selected' : '' }}>Low
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
                                                        name="product_handled_by" data-choices data-choices-search-false>
                                                        <option value="">Select Trailer</option>
                                                        @foreach ($trailers as $trailer)
                                                            <option value="{{ $trailer->id }}"
                                                                {{ old('product_handled_by') == $trailer->id ? 'selected' : '' }}>
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
                                    <!-- end row -->

                                </form>
                            </div>
                            <!--end tab-pane-->


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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#product-title-input').blur(function() {
                var customerNumber = $(this).val();

                // AJAX request to fetch customer data
                $.ajax({
                    url: '/admin/order/fetchcustomerdata', // Replace with your route for fetching customer data
                    method: 'GET',
                    data: {
                        customer_number: customerNumber
                    },
                    success: function(response) {
                        if (response.success) {
                            var customerData = response.data;

                            // Populate customer name and address fields
                            $('[name="customer_name"]').val(customerData.name);
                            $('[name="delivery_address"]').val(customerData.address);
                        } else {
                            // alert('Customer not found.');
                        }
                    },
                    error: function() {
                        // alert('Failed to fetch customer data.');
                    }
                });
            });
        });
    </script>
@endsection
@section('scripts')
<script type="text/javascript">
    window.onload = function(){
        //Ordered Date
        var orderNepaliDate = document.getElementById('order-nepali-date');
        orderNepaliDate.nepaliDatePicker();

        //Payment Date
        var paymentNepaliDate = document.getElementById('payment-nepali-date');
        paymentNepaliDate.nepaliDatePicker();

        //Delivery Date
        var deliveryNepaliDate = document.getElementById('delivery-nepali-date');
        deliveryNepaliDate.nepaliDatePicker();
    }
</script>
@endsection
