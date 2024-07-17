@extends('admin.layouts.main')

@php $title =  'Order Lists | Admin Panel'; @endphp

@section('content')
    <!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Daily Order List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.order.daily') }}">Daily Orders</a></li>
                                <li class="breadcrumb-item active">Daily Order List</li>
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
                                <h5 class="card-title mb-0 flex-grow-1">All Orders Info</h5>
                                <div class="flex-shrink-0">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('admin.order.order-list-pdf') }}?tab={{ request()->get('tab') }}&date={{ request()->get('date') ?  request()->get('date') : date('Y-m-d') }}" class="btn btn-success btn-sm"><i
                                            class="ri-download-2-fill align-middle me-1"></i> Download Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>






                        <br>


                        <div class="card-body">
                            <div class="table-responsive table-card mb-4">
                                <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::input('tab') == 'All' ? 'active' : '' }} py-3"
                                            id="All" href="{{ route('admin.order.index', ['tab' => 'All']) }}"
                                            role="tab"
                                            aria-selected="{{ Request::input('tab') == 'All' ? 'true' : 'false' }}">
                                            <i class="ri-store-2-fill me-1 align-bottom"></i> All Orders
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::input('tab') == 'Pickups' ? 'active' : '' }} py-3 Pickups"
                                            id="Pickups" href="{{ route('admin.order.index', ['tab' => 'Pickups']) }}"
                                            role="tab"
                                            aria-selected="{{ Request::input('tab') == 'Pickups' ? 'true' : 'false' }}">
                                            <i class="ri-truck-line me-1 align-bottom"></i> Inprogress
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::input('tab') == 'Pending' ? 'active' : '' }} py-3 Pending"
                                            id="Pending" href="{{ route('admin.order.index', ['tab' => 'Pending']) }}"
                                            role="tab"
                                            aria-selected="{{ Request::input('tab') == 'Pending' ? 'true' : 'false' }}">
                                            <i class="ri-record-circle-line me-1 align-bottom"></i> Pending
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::input('tab') == 'Delivered' ? 'active' : '' }} py-3 Delivered"
                                            id="Delivered" href="{{ route('admin.order.index', ['tab' => 'Delivered']) }}"
                                            role="tab"
                                            aria-selected="{{ Request::input('tab') == 'Delivered' ? 'true' : 'false' }}">
                                            <i class="ri-file-list-fill me-1 align-bottom"></i> Delivered
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::input('tab') == 'Completed' ? 'active' : '' }} py-3 Completed"
                                            id="Completed" href="{{ route('admin.order.index', ['tab' => 'Completed']) }}"
                                            role="tab"
                                            aria-selected="{{ Request::input('tab') == 'Completed' ? 'true' : 'false' }}">
                                            <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Completed
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::input('tab') == 'Returns' ? 'active' : '' }} py-3 Returns"
                                            id="Returns" href="{{ route('admin.order.index', ['tab' => 'Returns']) }}"
                                            role="tab"
                                            aria-selected="{{ Request::input('tab') == 'Returns' ? 'true' : 'false' }}">
                                            <i class="ri-arrow-left-right-fill me-1 align-bottom"></i> Returns
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::input('tab') == 'Cancelled' ? 'active' : '' }} py-3 Cancelled"
                                            id="Cancelled"
                                            href="{{ route('admin.order.index', ['tab' => 'Cancelled']) }}"
                                            role="tab"
                                            aria-selected="{{ Request::input('tab') == 'Cancelled' ? 'true' : 'false' }}">
                                            <i class="ri-close-circle-line me-1 align-bottom"></i> Cancelled
                                        </a>
                                    </li>

                                </ul>
                                <table class="table align-middle table-nowrap mb-0" id="tasksTable">

                                    <thead class="table-light text-muted" style="border: 1px solid #ddd;">
                                        <tr>

                                            <th style="border-r: 1px solid #ddd;" colspan="3">Customer Details</th>
                                            <th style="border: 1px solid #ddd;" colspan="6">Product Details</th>
                                            <th style="border: 1px solid #ddd;" colspan="5">Payment Details</th>
                                            <th style="border: 1px solid #ddd;" colspan="3">Delivery Details</th>
                                            <th style="border: 1px solid #ddd;" colspan="2">Action</th>

                                        </tr>
                                        <tr>
                                            <!-- Customer Details Headers -->
                                            <th col>SN</th>
                                            <th col>OrderId</th>

                                            <th>Name</th>
                                            <th>Contact Number</th>
                                            <th>Ordered Date</th>

                                            <!-- Product Details Headers -->
                                            <th>Product Name</th>
                                            <th>Qty</th>
                                            <th>price</th>
                                            <th>Handled By</th>
                                            <th>Status</th>
                                            <th>Priority</th>

                                            <!-- Payment Details Headers -->
                                            <th>PAYMENT METHOD</th>
                                            <th>Total AMOUNT</th>
                                            <th>Advance AMOUNT</th>
                                            <th>DATE PAID</th>

                                            <!-- Delivery Details Headers -->
                                            <th>DELIVERY METHOD</th>
                                            <th>EXPECTED DATE</th>
                                            <th>Charge</th>

                                            <th></th>

                                            <th></th>

                                        </tr>
                                        <form id="searchForm" action="{{ route('admin.order.index') }}" method="GET">
                                            <input type="hidden" name="tab"
                                                value="{{ Request::input('tab', 'All') }}">

                                            <tr>
                                                <th></th>
                                                <th><input type="text" id="ordersearch" name="order_id"
                                                        class="form-control" placeholder="Search order_id"
                                                        value="{{ request('order_id') }}"></th>
                                                <th><input type="text" id="customernamesearch" name="customer_name"
                                                        class="form-control" placeholder="Search name"
                                                        value="{{ request('customer_name') }}"></th>
                                                <th><input type="text" id="contact_number_search"
                                                        name="contact_number" class="form-control"
                                                        placeholder="Search contact"
                                                        value="{{ request('contact_number') }}"></th>
                                                <th><input type="date" id="orderdateSearch" name="orderdate"
                                                        class="form-control" placeholder="Search orderdate"
                                                        value="{{ request('orderdate') }}"></th>
                                                <th>
                                                    <select id="productSearch" name="product" class="form-select">
                                                        <option value="">Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                {{ $product->id == request('product') ? 'selected' : '' }}>
                                                                {{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </th>
                                                <th></th>
                                                <th></th>
                                                <th>
                                                    <select id="trailerSearch" name="handleby" class="form-select">
                                                        <option value="">Select handle by</option>
                                                        @foreach ($trailers as $trailer)
                                                            <option value="{{ $trailer->id }}"
                                                                {{ $trailer->id == request('handleby') ? 'selected' : '' }}>
                                                                {{ $trailer->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </th>




                                                <th>
                                                    <select class="form-select" id="statusSearch" name="status"
                                                        data-choices data-choices-search-false
                                                        name="choices-single-default2">
                                                        <option value="">Select Status</option>
                                                        <option value="Inprogress"
                                                            {{ request('status') == 'Inprogress' ? 'selected' : '' }}>
                                                            Inprogress</option>
                                                        <option value="Pending"
                                                            {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending
                                                        </option>
                                                        <option value="Delivered"
                                                            {{ request('status') == 'Delivered' ? 'selected' : '' }}>
                                                            Delivered</option>
                                                        <option value="Completed"
                                                            {{ request('status') == 'Completed' ? 'selected' : '' }}>
                                                            Completed</option>
                                                        <option value="Cancelled"
                                                            {{ request('status') == 'Cancelled' ? 'selected' : '' }}>
                                                            Cancelled</option>

                                                    </select>
                                                </th>

                                                <th>
                                                    <select class="form-select" name="priority" id="prioritySearch"
                                                        data-choices data-choices-search-true
                                                        name="choices-single-default2">
                                                        <option value="">Select Priority</option>
                                                        <option value="High"
                                                            {{ request('priority') == 'High' ? 'selected' : '' }}>High
                                                        </option>
                                                        <option value="Medium"
                                                            {{ request('priority') == 'Medium' ? 'selected' : '' }}>Medium
                                                        </option>
                                                        <option value="Low"
                                                            {{ request('priority') == 'Low' ? 'selected' : '' }}>Low
                                                        </option>

                                                    </select>
                                                </th>



                                                <th></th>
                                                <th></th>
                                                <th></th>
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
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td class="id">{{ $loop->index + 1 }}</td>
                                                <td class="id">{{ $order->order_id }}</td>

                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 tasks_name">{{ $order->customer_name }}
                                                        </div>

                                                    </div>
                                                </td>
                                                <td class="id"><a href="#"
                                                        class="fw-medium link-primary">{{ $order->customer_contact_number }}</a>
                                                </td>

                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 tasks_name">{{ $order->ordered_date }}
                                                        </div>

                                                    </div>
                                                </td>



                                                <td class="project_name"><a class="fw-medium link-primary">
                                                        @if (isset($order->product->image))
                                                            <img id="image-preview"
                                                                src="{{ asset('images/product/' . $order->product->image) }}"
                                                                alt="Image Preview"
                                                                style="max-width: 60px; height: 60px;">
                                                        @endif

                                                        {{ isset($order->product->name) ? $order->product->name : '' }}
                                                    </a></td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $order->quantity }}</a></td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $order->price }}</a></td>

                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ isset($order->trailer->name) ? $order->trailer->name : '-'}}</a>
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $order->status }}</a></td>
                                                <td class="project_name">
                                                    @php
                                                        $priorityClass = '';
                                                        switch ($order->priority) {
                                                            case 'Low':
                                                                $priorityClass = 'btn-low';
                                                                break;
                                                            case 'Medium':
                                                                $priorityClass = 'btn-medium';
                                                                break;
                                                            case 'High':
                                                                $priorityClass = 'btn-high';
                                                                break;
                                                            default:
                                                                $priorityClass = 'btn-default'; // Default color if priority is not recognized
                                                        }
                                                    @endphp
                                                    <a
                                                        class="fw-medium link-primary btn {{ $priorityClass }}">{{ $order->priority }}</a>
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $order->payment_method }}</a>
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $order->quantity * $order->price }}</a>
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $order->advance }}</a>
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $order->payment_date }}</a>
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $order->delivery_partner_id ? $order->delivery->delivery_company_name : '-' }}</a>
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $order->delivery_date ? $order->delivery_date : '-' }}</a>
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $order->delivery_charge ? $order->delivery_charge : '-' }}</a>
                                                </td>
                                                <td class="assignedto">
                                                    <a href="{{ route('admin.order.edit', $order->id) }}"
                                                        class="btn btn-outline-success">Edit</a>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-bs-toggle="modal" href="#deleteOrder{{ $order->id }}">
                                                        Delete
                                                    </button>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                                <!--end table-->
                                <div class="noresult" style="display: none">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a"
                                            style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
            @foreach ($orders as $user)
                <div class="modal fade flip" id="deleteOrder{{ $user->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                    colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4>You are about to delete a vendor ?</h4>
                                    <p class="text-muted fs-14 mb-4">Deleting your vendor will remove all of
                                        your information from our database.</p>

                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link btn-ghost-success fw-medium text-decoration-none"
                                            id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <form method="POST" action="{{ route('admin.order.delete', $user->id) }}"
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


        </div>
        <!-- container-fluid -->
    </div>
    <style>
        .btn-low,
        .btn-high,
        .btn-default {
            color: #fff !important;
            /* Set text color to white */
        }

        .btn-low {
            background-color: green;
            /* Set low priority color */
        }

        .btn-medium {
            background-color: yellow;
            /* Set medium priority color */
        }

        .btn-high {
            background-color: red;
            /* Set high priority color */
        }

        .btn-default {
            background-color: gray;
            /* Set default color */
        }
    </style>
    <script>
        // Get the form element
        const searchForm = document.getElementById('searchForm');

        // Add event listeners to input fields and select elements
        document.getElementById('customernamesearch').addEventListener('keypress', handleEnter);
        document.getElementById('ordersearch').addEventListener('keypress', handleEnter);
        document.getElementById('contact_number_search').addEventListener('keypress', handleEnter);
        document.getElementById('orderdateSearch').addEventListener('keypress', handleEnter);
        document.getElementById('productSearch').addEventListener('change', submitForm);
        document.getElementById('trailerSearch').addEventListener('change', submitForm);
        document.getElementById('statusSearch').addEventListener('change', submitForm);
        document.getElementById('prioritySearch').addEventListener('change', submitForm);

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
    <!-- End Page-content -->


    <!-- end main content-->


    <!-- End Page-content -->
@endsection
