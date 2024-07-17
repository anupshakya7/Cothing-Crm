@extends('admin.layouts.main')

@php $title =  'Enquiry Create | Admin Panel'; @endphp

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Enquiry</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.enquiry.index') }}">Enquiry</a></li>
                                <li class="breadcrumb-item active">Create Enquiry</li>
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
                                    Enquiry Details
                                </a>
                            </li>

                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form action="{{ route('admin.enquiry.store') }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="false">
                                    @csrf
                                    @method('POST')
                                    <div class="row">


                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">
                                                    Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    id="firstnameInput" placeholder="Enter  Name"
                                                    value="{{ old('name') }}">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">
                                                    Contact Number</label>
                                                <input type="number" class="form-control" name="contact_number"
                                                    id="firstnameInput" placeholder="Enter  contact number"
                                                    value="{{ old('contact_number') }}">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('contact_number') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="skillsInput" class="form-label">Source Type</label>
                                                <select class="form-select" name="source_type" data-choices
                                                    data-choices-search-false name="choices-single-default2">
                                                    <option value="">Select Source Type</option>
                                                    <option value="Call">Call</option>
                                                    <option value="Online">Online</option>

                                                </select>

                                                <div class="invalid-feedback">
                                                    {{ $errors->first('source_type') }}
                                                </div>


                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="skillsInput" class="form-label">Source</label>
                                                <select class="form-select" name="source" data-choices
                                                    data-choices-search-false name="choices-single-default2">
                                                    <option value="">Select Source</option>
                                                    <option value="Facebook">Facebook</option>
                                                    <option value="Instagram">Instagram</option>
                                                    <option value="WhatsApp">WhatsApp</option>
                                                    <option value="Viber">Viber</option>
                                                    <option value="Others">Others</option>

                                                </select>

                                                <div class="invalid-feedback">
                                                    {{ $errors->first('source') }}
                                                </div>


                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="skillsInput" class="form-label">Priority</label>
                                                <select class="form-select" name="priority" data-choices
                                                    data-choices-search-false name="choices-single-default2">
                                                    <option value="">Select Priority</option>
                                                    <option value="High">High</option>
                                                    <option value="Medium">Medium</option>
                                                    <option value="Low">Low</option>

                                                </select>

                                                <div class="invalid-feedback">
                                                    {{ $errors->first('priority') }}
                                                </div>


                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="skillsInput" class="form-label">Status</label>
                                                <select class="form-select" name="status" data-choices
                                                    data-choices-search-false name="choices-single-default2">
                                                    <option value="">Select Status</option>
                                                    <option value="Inprogress">Inprogress</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Completed">Completed</option>

                                                </select>

                                                <div class="invalid-feedback">
                                                    {{ $errors->first('source_type') }}
                                                </div>


                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">
                                                    Handled By</label>
                                                <select class="form-select" id="handleSearch" name="handled_by"
                                                    data-choices data-choices-search-false name="choices-single-default2">
                                                    <option value="">Select Handle by</option>
                                                    @foreach ($handle_bys as $hanlde_by)
                                                        <option value="{{ $hanlde_by->id }}"
                                                            {{ old('handled_by') == $hanlde_by->id ? 'selected' : '' }}>
                                                            {{ $hanlde_by->name }}</option>
                                                    @endforeach


                                                </select>

                                                <div class="invalid-feedback">
                                                    {{ $errors->first('handled_by') }}
                                                </div>
                                            </div>
                                        </div>





                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">Remarks</label>
                                                <textarea class="form-control" name="remarks">{{ old('remaks') }}</textarea>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('remarks') }}
                                                </div>
                                            </div>
                                        </div>

                                        <!--end col-->

                                        <div class="card-body p-4">
                                            <div class="table-responsive">
                                                <table class="invoice-table table table-borderless table-nowrap mb-0">
                                                    <thead class="align-middle">
                                                        <tr class="table-active">
                                                            <th scope="col" style="width: 50px;">#</th>
                                                            <th scope="col">Follow Up Details</th>
                                                            <th scope="col" style="width: 120px;">Followup Date</th>
                                                            <th scope="col" class="text-end" style="width: 150px;">
                                                            </th>
                                                            <th scope="col" class="text-end" style="width: 105px;">
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="followup-details">
                                                        <tr class="product">
                                                            <th scope="row" class="product-id">1</th>
                                                            <td class="text-start">
                                                                <div class="mb-2">
                                                                    <textarea class="form-control bg-light border-0 followup-details" name="followup_remarks[]" rows="2"
                                                                        placeholder="Followup Details"></textarea>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control bg-light border-0 followup-date followup-nepali-datepicker" style="width:110%;"
                                                                    name="followup_date[]" placeholder="Followup date"
                                                                    required/>
                                                            </td>
                                                            <td class="product-removal">
                                                                <a href="javascript:void(0)"
                                                                    class="btn btn-success btn-delete">Delete</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="5">
                                                                <button type="button" id="add-item"
                                                                    class="btn btn-soft-secondary fw-medium"><i
                                                                        class="ri-add-fill me-1 align-bottom"></i> Add
                                                                    Item</button>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <!--end table-->
                                            </div>
                                        </div>


                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary">Create</button>
                                                <a href="{{ route('admin.enquiry.index') }}" type="button"
                                                    class="btn btn-soft-success">Cancel</a>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
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
    <!--Nepali Date Picker-->
    <script type="text/javascript">
        window.onload = function(){
            var followDate = document.getElementsByClassName('followup-nepali-datepicker');
            followDate.nepaliDatePicker();
        }
    </script>

    <script>
        function addNewItem() {
            var table = document.getElementById('followup-details');
            var newRow = table.insertRow();
            newRow.className = 'product';
            var cellId = newRow.insertCell(0);
            cellId.className = 'product-id';
            cellId.textContent = table.rows.length;

            var cellDetails = newRow.insertCell(1);
            var detailsTextarea = document.createElement('textarea');
            detailsTextarea.className = 'form-control bg-light border-0 followup-details';
            detailsTextarea.name = 'followup_remarks[]';
            detailsTextarea.rows = 2;
            detailsTextarea.placeholder = 'Followup Details';
            cellDetails.appendChild(detailsTextarea);

            var cellDate = newRow.insertCell(2);
            var dateInput = document.createElement('input');
            dateInput.type = 'text';
            dateInput.className = 'form-control bg-light border-0 followup-date followup-nepali-datepicker';
            dateInput.style.width = '110%';
            dateInput.name = 'followup_date[]';
            dateInput.placeholder = 'Followup date';
            dateInput.required = true;
            cellDate.appendChild(dateInput);

            var cellRemoval = newRow.insertCell(3);
            var deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'btn btn-success btn-delete';
            deleteButton.textContent = 'Delete';
            deleteButton.addEventListener('click', function() {
                deleteRow(newRow);
            });
            cellRemoval.appendChild(deleteButton);

            $('.followup-nepali-datepicker').nepaliDatePicker();
        }

        function deleteRow(row) {
            var table = document.getElementById('followup-details');
            row.parentNode.removeChild(row);
            updateIds();
        }

        function updateIds() {
            var table = document.getElementById('followup-details');
            var rows = table.getElementsByClassName('product');
            for (var i = 0; i < rows.length; i++) {
                rows[i].getElementsByClassName('product-id')[0].textContent = i + 1;
            }
        }

        document.getElementById('add-item').addEventListener('click', function() {
            addNewItem();
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Add delete functionality to existing delete buttons
            var deleteButtons = document.getElementsByClassName('btn-delete');
            for (var i = 0; i < deleteButtons.length; i++) {
                deleteButtons[i].addEventListener('click', function() {
                    deleteRow(this.parentNode.parentNode);
                });
            }
        });
    </script>



    <script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function() {
                var imagePreview = document.getElementById('image-preview');
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
