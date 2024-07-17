@extends('admin.layouts.main')

@php $title =  'vendorpayment | Admin Panel'; @endphp

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Vendor Payment</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.vendors-payment.index') }}">Vendors
                                        Payment</a></li>
                                <li class="breadcrumb-item active">Edit Vendor Payment</li>
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
                                        Vendor Payment Details
                                    </a>
                                </li>


                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                    <form action="{{ route('admin.vendors-payment.update', $payment->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="vendorInput" class="form-label">Vendor</label>
                                                    <select class="form-select {{ $errors->has('vendor') ? 'is-invalid' : '' }} select2" name="vendor" id="choices-vendor-select">
                                                        <option value="">Select Vendor</option>
                                                        @foreach ($vendors as $vendor)
                                                            <option value="{{ $vendor->id }}"
                                                                {{ $vendor->id == old('vendor',$payment->vendor_id) ? 'selected' : '' }}>
                                                                {{ $vendor->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('vendor') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="totalAmountInput" class="form-label">Total Amount</label>
                                                    <input type="number" class="form-control" name="amount"
                                                        id="totalAmountInput" placeholder="Enter Total Amount"
                                                        value="{{ $payment->total_amount }}">
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('amount') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="dateInput" class="form-label">Date</label>
                                                    <input type="text" id="nepali-date-picker" class="form-control" name="date"
                                                        value="{{ $payment->date }}">
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('date') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="receivedInput" class="form-label">Received By</label>
                                                    <input type="text" class="form-control" name="received_by"
                                                        id="receivedInput" placeholder="Enter Received By"
                                                        value="{{ $payment->received_by }}">
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('received_by') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="receivedMethodInput" class="form-label">Received
                                                        Method</label>
                                                    <select class="form-select" id="choices-publish-status-input"
                                                        name="received_method" data-choices data-choices-search-false>
                                                        <option value="">Select Received
                                                            Payment Method
                                                        </option>

                                                        <option value="Esewa"
                                                            {{ $payment->received_method == 'Esewa' ? 'selected' : '' }}>
                                                            Esewa</option>
                                                        <option value="Khalti"
                                                            {{ $payment->received_method == 'Khalti' ? 'selected' : '' }}>
                                                            Khalti
                                                        </option>
                                                        <option value="Fonepay"
                                                            {{ $payment->received_method == 'Fonepay' ? 'selected' : '' }}>
                                                            Fonepay</option>
                                                        <option value="Remit"
                                                            {{ $payment->received_method == 'Remit' ? 'selected' : '' }}>
                                                            Remit</option>
                                                        <option value="Cash"
                                                            {{ $payment->received_method == 'Cash' ? 'selected' : '' }}>
                                                            Cash</option>
                                                        <option value="Bank"
                                                            {{ $payment->received_method == 'Bank' ? 'selected' : '' }}>
                                                            Bank</option>

                                                        <option value="Delivery Partner"
                                                            {{ $payment->received_method == 'Delivery Partner' ? 'selected' : '' }}>
                                                            Delivery Partner</option>

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('received_method') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="remarksInput" class="form-label">Remarks</label>
                                                    <textarea class="form-control" placeholder="Enter the remarks" id="remarksInput" name="remarks" rows="3">{{ $payment->remarks }}</textarea>
                                                </div>
                                            </div>
                                            <!--end col-->


                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Updates</button>
                                                    <a href="{{ route('admin.vendors-payment.index') }}" type="button"
                                                        class="btn btn-soft-success">Cancel</a>
                                                </div>
                                            </div>
                                            <!--end col-->
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
@endsection

@push('default-scripts')
    <!-- ckeditor -->
    <script src="{{ URL::asset('/assets') }}/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

    <!-- dropzone js -->
    <script src="{{ URL::asset('/assets') }}/libs/dropzone/dropzone-min.js"></script>
    <!-- project-create init -->
    <script src="{{ URL::asset('/assets') }}/js/pages/project-create.init.js"></script>
    <script>
        var previewTemplate1, dropzone1, dropzonePreviewNode1 = (document.querySelector("#dropzone-preview-list1"));
        dropzonePreviewNode1 && (dropzonePreviewNode1.id = "", previewTemplate1 = dropzonePreviewNode1.parentNode.innerHTML,
            dropzonePreviewNode1.parentNode.removeChild(dropzonePreviewNode1), dropzone1 = new Dropzone(".dropzone1", {
                url: "https://httpbin.org/post",
                method: "post",
                previewTemplate: previewTemplate1,
                previewsContainer: "#dropzone-preview1"
            }));
    </script>

    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            $('#output').show();

            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory

            }
        };

        document.getElementById('group-image').addEventListener('change', function() {
            document.getElementById('imagehide').style.display = 'none';
        });
    </script>
@endpush

@section('scripts')
<script type="text/javascript">
    window.onload = function(){
        var date = document.getElementById('nepali-date-picker');
        date.nepaliDatePicker();
    }
</script>
@endsection
