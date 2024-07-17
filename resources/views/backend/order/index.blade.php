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
                        <h4 class="mb-sm-0">Order List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.order.index') }}">Orders</a></li>
                                <li class="breadcrumb-item active">Order List</li>
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
                                        <a href="{{ route('admin.order.create') }}" class="btn btn-danger add-btn"><i
                                                class="ri-add-line align-bottom me-1"></i> Create Order</a>
                                        <button class="btn btn-soft-danger" id="remove-actions"
                                            onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="card-title flex-grow-1 mb-0">
                                    <form id="ordersearchForm" action="{{ route('admin.order.index') }}" method="GET"
                                        class="row g-3 align-items-center">
                                        <input type="hidden" name="tab" value="{{ Request::input('tab', 'All') }}">
                                        <div class="row">
                                            {{-- <div class="col-auto">
                                        <label for="tabsearch" class="col-form-label">Status</label>
                                        <select id="tabsearch" name="optiontab" class="form-select">
                                            <option value="All">All</option>
                                            <option value="Pickups">Inprogress</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Delivered">Delivered</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Returns">Returns</option>
                                            <option value="Cancelled">Cancelled</option>
                                        </select>
                                    </div> --}}
                                            <div class="col-auto">
                                                <label for="fromDate" class="col-form-label">From Date</label>
                                                <input type="text" id="fromDate" name="fromDate" class="form-control"
                                                    placeholder="From Date" value="{{ request('fromDate') }}">
                                            </div>
                                            <div class="col-auto">
                                                <label for="toDate" class="col-form-label">To Date</label>
                                                <input type="text" id="toDate" name="toDate" class="form-control"
                                                    placeholder="To Date" value="{{ request('toDate') }}">
                                            </div>
                                            <div class="col-auto">
                                                <label for="tabsearch" class="col-form-label">&nbsp;</label>
                                                <input type="submit" class="form-control btn btn-primary" value="Search">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="flex-shrink-0">
                                    <button id="print-selected" class="btn btn-primary btn-sm">Download Selected Print</button>


                                    <a href="{{ route('admin.order.order-list-pdf') }}?tab={{ request()->get('tab') }}&fromDate={{ request()->get('fromDate') }}&toDate={{ request()->get('toDate') }}"
                                        class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i>
                                        Download Print</a>
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
                                        <a class="nav-link {{ Request::input('tab') == 'Hold' ? 'active' : '' }} py-3 Hold"
                                            id="Hold" href="{{ route('admin.order.index', ['tab' => 'Hold']) }}"
                                            role="tab"
                                            aria-selected="{{ Request::input('tab') == 'Hold' ? 'true' : 'false' }}">
                                            <i class="ri-truck-line me-1 align-bottom"></i> Hold
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
                                            id="Completed"
                                            href="{{ route('admin.order.index', ['tab' => 'Completed']) }}"
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
                                <div class="summary " style="float: right;margin-right:1rem">Total Orders :
                                    <b>{{ $ordercount }}</b> items.</div>
                                <div class="table-fixed-wrapper double-scroll">

                                    <table class="table align-middle table-nowrap mb-0" id="tasksTable">

                                        <thead class="table-light text-muted" style="border: 1px solid #ddd;">
                                            <tr>

                                                <th style="border-r: 1px solid #ddd;" colspan="5">Customer Details
                                                </th>
                                                <th style="border: 1px solid #ddd;" colspan="6">Product Details
                                                </th>
                                                <th style="border: 1px solid #ddd;" colspan="5">Payment Details
                                                </th>
                                                <th style="border: 1px solid #ddd;" colspan="3">Delivery Details
                                                </th>
                                                <th style="border: 1px solid #ddd;" colspan="2">Action</th>

                                            </tr>
                                            <tr>
                                                <th></th>

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
                                                <th>Due Amount</th>
                                                <th>DATE PAID</th>

                                                <!-- Delivery Details Headers -->
                                                <th>DELIVERY METHOD</th>
                                                <th>EXPECTED DATE</th>
                                                <th>Charge</th>

                                                <th></th>

                                                <th></th>

                                            </tr>
                                            <form id="searchForm" action="{{ route('admin.order.index') }}"
                                                method="GET">
                                                <input type="hidden" name="tab"
                                                    value="{{ Request::input('tab', 'All') }}">

                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th><input type="text" id="ordersearch" name="order_id"
                                                            class="form-control" placeholder="Search order_id"
                                                            value="{{ request('order_id') }}"></th>
                                                    <th><input type="text" id="customernamesearch"
                                                            name="customer_name" class="form-control"
                                                            placeholder="Search name"
                                                            value="{{ request('customer_name') }}"></th>
                                                    <th><input type="text" id="contact_number_search"
                                                            name="contact_number" class="form-control"
                                                            placeholder="Search contact"
                                                            value="{{ request('contact_number') }}"></th>
                                                    <th><input type="text" id="orderdateSearch" name="orderdate"
                                                            class="form-control" placeholder="Search orderdate"
                                                            value="{{ request('orderdate') }}"></th>
                                                    <th>
                                                        <select id="productSearch" name="product"
                                                            class="form-select select2" onchange="submit();">
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
                                                        <select class="form-select" id="statusSearch" name="status">
                                                            <option value="">Select Status</option>
                                                            <option value="Inprogress"
                                                                {{ request('status') == 'Inprogress' ? 'selected' : '' }}>
                                                                Inprogress</option>
                                                            <option value="Hold"
                                                            {{ request('status') == 'Hold' ? 'selected' : '' }}>
                                                            Hold</option>

                                                            <option value="Pending"
                                                                {{ request('status') == 'Pending' ? 'selected' : '' }}>
                                                                Pending
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
                                                        <select class="form-select" name="priority" id="prioritySearch">
                                                            <option value="">Select Priority</option>
                                                            <option value="High"
                                                                {{ request('priority') == 'High' ? 'selected' : '' }}>
                                                                High
                                                            </option>
                                                            <option value="Medium"
                                                                {{ request('priority') == 'Medium' ? 'selected' : '' }}>
                                                                Medium
                                                            </option>
                                                            <option value="Low"
                                                                {{ request('priority') == 'Low' ? 'selected' : '' }}>
                                                                Low
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
                                                    <th></th>


                                                    <th></th> <!-- eave this column empty for Action column -->
                                                </tr>
                                            </form>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="order-checkbox" name="order_ids[]" value="{{ $order->id }}">
                                                    </td>

                                                    <td class="id">{{ $loop->index + 1 }}</td>
                                                    <td class="id">
                                                        <a href="{{ route('admin.order.edit', $order->id) }}">
                                                            {{ $order->order_id ?? '-' }}
                                                        </a>
                                                        <a href="{{ route('admin.order.order-invoice', $order->id) }}"
                                                            class="btn btn-soft-danger btn-sm mt-2 mt-sm-0"><i
                                                                class="mdi mdi-archive-remove-outline align-middle me-1"></i>
                                                            Invoice</a>
                                                    </td>

                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1 tasks_name">
                                                                {{ $order->customer_name }}
                                                            </div>

                                                        </div>
                                                    </td>
                                                    <td class="id"><a href="#"
                                                            class="fw-medium link-primary">{{ $order->customer_contact_number }}</a>
                                                    </td>

                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1 tasks_name">
                                                                {{ $order->ordered_date }}
                                                            </div>

                                                        </div>
                                                    </td>



                                                    <td class="project_name"><a class="fw-medium link-primary">
                                                            {{-- @if (isset($order->product->image))
                                                            <img id="image-preview"
                                                                src="{{ asset('images/product/' . $order->product->image) }}"
                                                                alt="Image Preview"
                                                                style="max-width: 60px; height: 60px;">
                                                        @endif --}}

                                                            @isset($order->orderProducts)
                                                                <ul>
                                                                    @foreach ($order->orderProducts as $data)
                                                                        <li>{{ isset($data->product->name) ? $data->product->name : '' }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endisset
                                                        </a></td>
                                                    <td class="project_name"><a class="fw-medium link-primary">
                                                            @isset($order->orderProducts)
                                                                <ul>
                                                                    @foreach ($order->orderProducts as $data)
                                                                        <li>{{ $data->quantity }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @endisset
                                                        </a></td>
                                                    <td class="project_name"><a class="fw-medium link-primary">
                                                            @isset($order->orderProducts)
                                                                <ul>
                                                                    @foreach ($order->orderProducts as $data)
                                                                        <li>{{ $data->price }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @endisset
                                                        </a></td>

                                                    <td class="project_name"><a
                                                            class="fw-medium link-primary">{{ isset($order->trailer->name) ? $order->trailer->name : '-' }}</a>
                                                    </td>
                                                    <td class="project_name"><a
                                                            class="fw-medium link-primary">{{ $order->status }}</a>
                                                    </td>
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
                                                    <td class="project_name">

                                                        @isset($order->orderPayment)
                                                            <ul>
                                                                @foreach ($order->orderPayment as $data)
                                                                    @if ($data->payment_method)
                                                                        <li>{{ $data->payment_method }}</li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        @endisset

                                                    </td>
                                                    <td class="project_name"><a
                                                            class="fw-medium link-primary">{{ $order->total_price }}</a>
                                                    </td>
                                                    <td class="project_name"><a class="fw-medium link-primary">
                                                            @isset($order->orderPayment)
                                                                <ul>
                                                                    @foreach ($order->orderPayment as $data)
                                                                        @if ($data->amount)
                                                                            <li>{{ $data->amount }}</li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            @endisset
                                                        </a>
                                                    </td>
                                                    <td class="project_name"><a
                                                            class="fw-medium link-primary">{{ $order->outstading_price }}</a>
                                                    </td>
                                                    <td class="project_name"> @isset($order->orderPayment)
                                                            <ul>
                                                                @foreach ($order->orderPayment as $data)
                                                                    @if ($data->payment_date)
                                                                        <li>{{ $data->payment_date }}</li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        @endisset
                                                    </td>
                                                    <td class="project_name"><a
                                                            class="fw-medium link-primary">{{ $order->delivery_partner_id && isset($order->delivery->delivery_company_name) ? $order->delivery->delivery_company_name : '-' }}</a>
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
                                                            data-bs-toggle="modal"
                                                            href="#deleteOrder{{ $order->id }}">
                                                            Delete
                                                        </button>
                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                </div>

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
                            @if ($orders->hasPages())
                                {{ $orders->links('vendor.pagination.bootstrap-4') }}
                            @endif

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
    {{-- <link href="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/css/nepali.datepicker.v4.0.1.min.css"
        rel="stylesheet" type="text/css" />

    <script src="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.1.min.js"
        type="text/javascript"></script> --}}

    <script type="text/javascript">
        window.onload = function() {
            var mainInput = document.getElementById("orderdateSearch");
            mainInput.nepaliDatePicker();

            var mainInput1 = document.getElementById("fromDate");
            mainInput1.nepaliDatePicker();

            var mainInput2 = document.getElementById("toDate");
            mainInput2.nepaliDatePicker();
        };
    </script>
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

        .select2.select2-container {
            width: 100% !important;
            top: 8px;
        }

        .table-fixed-wrapper {
            margin: auto;
            max-height: calc(100vh - 190px);
            overflow-y: auto !important;
            overflow-x: auto !important;
            position: relative;
            width: 100%;
            z-index: 1;
        }

        .table-fixed-wrapper table thead th {
            position: sticky;
            top: 0;
            z-index: 5;
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

<script>
    document.getElementById('print-selected').addEventListener('click', function() {
        var selectedOrders = [];
        document.querySelectorAll('.order-checkbox:checked').forEach(function(checkbox) {
            selectedOrders.push(checkbox.value);
        });

        if (selectedOrders.length > 0) {
            // Create a form to submit selected orders for printing
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('admin.order.print') }}'; // Adjust the route as necessary

            // Add CSRF token
            var token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = '{{ csrf_token() }}';
            form.appendChild(token);

            // Add selected order IDs
            selectedOrders.forEach(function(orderId) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'order_ids[]';
                input.value = orderId;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        } else {
            alert('Please select at least one order to print.');
        }
    });
</script>

    <!-- End Page-content -->


    <!-- end main content-->


    <!-- End Page-content -->
@endsection

@push('default-scripts')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.double-scroll').doubleScroll();
        });
    </script>
    <script src="{{ URL::asset('/assets') }}/js/doublescroll.js"></script>
@endpush
