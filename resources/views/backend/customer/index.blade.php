@extends('admin.layouts.main')

@php $title =  'Customers Lists | Admin Panel'; @endphp
@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection
@section('content')
    <!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Customer List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Customer</a></li>
                                <li class="breadcrumb-item active">Customer List</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="tasksList">
                        <div class="card-header border-0">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0 flex-grow-1">All Customer Info</h5>
                                <div class="flex-shrink-0">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('admin.customer.create') }}" class="btn btn-danger add-btn"><i
                                                class="ri-add-line align-bottom me-1"></i> Create Customer</a>
                                        <button class="btn btn-soft-danger" id="remove-actions"
                                            onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="table-responsive table-card mb-4">
                                <table class="table align-middle table-nowrap mb-0" id="tasksTable">
                                    <thead class="table-light text-muted">
                                        <tr>

                                            <th data-sort="project_name">S.N</th>
                                            <th class=" text-center" data-sort="sms">SMS</th>
                                            <th data-sort="tasks_name">Name</th>
                                            <th data-sort="assignedto">Contact Number</th>
                                            <th data-sort="assignedto">Address</th>
                                            <th data-sort="assignedto">Email</th>
                                            <th data-sort="assignedto">Source</th>
                                            <th data-sort="assignedto">Total Order </th>
                                            <th data-sort="assignedto">Total Sales</th>
                                            <th data-sort="due_date">Action</th>

                                        </tr>
                                        <form id="searchForm" action="{{ route('admin.customer.index') }}" method="GET">
                                            <tr>
                                                <th></th>
                                                <th></th>

                                                <th>
                                                    <div class="d-flex align-items-center">
                                                        <select name="filter_letter" class="form-select select2 me-2"
                                                            onchange="this.form.submit()">
                                                            <option value="">Select Letter</option>
                                                            @foreach (range('A', 'Z') as $letter)
                                                                <option value="{{ $letter }}"
                                                                    {{ request('filter_letter') == $letter ? 'selected' : '' }}>
                                                                    {{ $letter }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="text" id="customersearch" name="customer_name"
                                                            class="form-control" placeholder="Search customer"
                                                            value="{{ request('customer_name') }}">
                                                    </div>
                                                </th>


                                                <th><input type="text" id="phonenumbersearch"
                                                        name="customer_contact_number" class="form-control ms-2"
                                                        placeholder="Search contact number"
                                                        value="{{ request('customer_contact_number') }}"></th>

                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th> <!-- eave this column empty for Action column -->
                                            </tr>
                                        </form>

                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($customers as $item)
                                            <tr>
                                                <td class="id">{{ $loop->index + 1 }}</td>
                                                <td class="text-center"><a
                                                        class="sms_modal fw-medium link-primary cursor-pointer"
                                                        data-bs-toggle="modal" data-bs-target="#smsModal"
                                                        data-customer-title="{{ $item->customer_name }}"
                                                        data-customer-number="{{ $item->customer_contact_number }}"><i
                                                            class="fas fa-comment-alt fa-lg"></i></a>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 tasks_name">{{ $item->customer_name }}
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $item->customer_contact_number }}</a>
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $item->address }}</a></td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $item->email }}</a></td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $item->source }}</a></td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $item->orders_count }}</a></td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ number_format($item->orders_sum_total_price) }}</a></td>

                                                <td class="assignedto">
                                                    <a href="{{ route('admin.customer.edit', $item->id) }}"
                                                        class="btn btn-outline-success">Edit</a>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-bs-toggle="modal" href="#deleteOrder{{ $item->id }}">
                                                        Delete
                                                    </button>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                                <!--end table-->

                            </div>
                            @if ($customers->count() == 0)
                                <div class="noresult">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a"
                                            style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                    </div>
                                </div>
                        </div>
                        @endif

                        @if ($customers->hasPages())
                            {{ $customers->links('vendor.pagination.bootstrap-4') }}
                        @endif

                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
        @foreach ($customers as $user)
            <div class="modal fade flip" id="deleteOrder{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-5 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                            <div class="mt-4 text-center">
                                <h4>You are about to delete a item ?</h4>
                                <p class="text-muted fs-14 mb-4">Deleting your items will remove all of
                                    your information from our database.</p>

                                <div class="hstack gap-2 justify-content-center remove">
                                    <button class="btn btn-link btn-ghost-success fw-medium text-decoration-none"
                                        id="deleteRecord-close" data-bs-dismiss="modal"><i
                                            class="ri-close-line me-1 align-middle"></i> Close</button>
                                    <form method="POST" action="{{ route('admin.customer.delete', $user->id) }}"
                                        style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" id="delete-record">Yes, Delete
                                            It</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!--end delete modal -->

        <!--sms modal -->
        <div class="modal fade" id="smsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel">Send SMS to <span id="customer_title"></span>
                            (<span id="customer_number"></span>)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>
                    <form action="{{ route('send.sms') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="sender_number" value="Tukutuku Nepal">
                            <input type="hidden" name="des_number" id="des_number">
                            <div class="mb-3">
                                <label for="customername-field" class="form-label">Message</label>
                                <textarea class="form-control" name="message" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-soft-success" id="add-btn">Send SMS</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--sms modal ends-->

    </div>
    <!-- container-fluid -->
    </div>
    <!-- End Page-content -->


    <!-- end main content-->


    <!-- End Page-content -->

    <script>
        // Get the form element
        const searchForm = document.getElementById('searchForm');

        // Add event listeners to input fields and select element
        document.getElementById('customersearch').addEventListener('keypress', handleEnter);
        document.getElementById('phonenumbersearch').addEventListener('keypress', handleEnter);


        // Function to submit the form when Enter is pressed in input fields
        function handleEnter(event) {
            if (event.key === 'Enter') {
                submitForm();
            }
        }

        // Function to submit the form when an option is selected from the dropdown
        function submitForm() {
            searchForm.submit();
        }
    </script>
    <style>
        .select2.select2-container {
            width: 100% !important;
            top: 6px;
            margin-right: 5px;
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.sms_modal').click(function() {
                var customerName = $(this).attr('data-customer-title');
                var customerContact = $(this).attr('data-customer-number');

                $('#customer_title').text(customerName);
                $('#customer_number').text(customerContact);
                $('#des_number').val(customerContact);
            });
        });
    </script>
@endsection
