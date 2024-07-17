@php
    $title = 'Admin Dashboard';

@endphp
@extends('admin.layouts.main')
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">CRM TukuTuku Nepal</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">CRM TukuTuku Nepal</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row project-wrapper">
                <div class="col-xxl-12">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                                                <i data-feather="briefcase" class="text-primary"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden ms-3">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Active Vendors
                                            </p>
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                        data-target="{{ $vendors->count() }}">0</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->

                        <div class="col-xl-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-warning text-warning rounded-2 fs-2">
                                                <i data-feather="award" class="text-warning"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-uppercase fw-medium text-muted mb-3">New Enquiry</p>
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                        data-target="{{ $enquiry->count() }}">0</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->

                        <div class="col-xl-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-info text-info rounded-2 fs-2">
                                                <i data-feather="clock" class="text-info"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden ms-3">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Total Orders
                                            </p>
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                        data-target="{{ $order->count() }}">0</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->


                </div><!-- end col -->

                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h4 class="card-title mb-0">This month Enquiry</h4>
                        </div><!-- end cardheader -->
                        <div class="card-body pt-0">
                            <div class="upcoming-scheduled">
                                <input type="text" class="form-control" data-provider="flatpickr"
                                    data-date-format="d M, Y" data-deafult-date="today" data-inline-date="true">
                            </div>

                            <h6 class="text-uppercase fw-semibold mt-4 mb-3 text-muted">Enquiry:</h6>
                            @if ($enquirydata->count() > 0)
                                @foreach ($enquirydata as $data)
                                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                                        <div class="flex-shrink-0 avatar-sm">
                                            <span
                                                class="mini-stat-icon avatar-title rounded-circle text-success bg-soft-success fs-4">
                                                {{ date('m', strtotime($data->created_at)) }}
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ $data->name }}</h6>
                                            <p class="text-muted mb-0">{{ $data->mobile }} </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <p class="text-muted mb-0">{{ $data->source_type }} <span
                                                    class="text-uppercase">{{ $data->source }}</span></p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            <h5 class="text-uppercase fw-semibold mt-4 mb-3 ">No Lead in this month</h5>

                            @endif
                            <!-- end -->


                            <div class="mt-3 text-center">
                                <a href="{{ route('admin.enquiry.index') }}"
                                    class="text-muted text-decoration-underline">View all Enquiry</a>
                            </div>

                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-xl-7">
                    <div class="card card-height-100">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title flex-grow-1 mb-0">Pending Orders</h4>
                            <div class="flex-shrink-0">
                                {{-- <a href="javascript:void(0);" class="btn btn-soft-info btn-sm">Export Report</a> --}}
                            </div>
                        </div><!-- end cardheader -->
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-nowrap table-centered align-middle">
                                    <thead class="bg-light text-muted">
                                        <tr>
                                            <th scope="col">Customer Name</th>
                                            <th scope="col">Contact Number</th>
                                            <th scope="col">Ordered Date</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Handled By</th>
                                            <th scope="col" style="width: 10%;">Due Date</th>
                                        </tr><!-- end tr -->
                                    </thead><!-- thead -->

                                    <tbody>
                                        @foreach ($order->where('status','Pending')->paginate(5) as $data)
                                        <tr>
                                            <td class="fw-medium">{{ $data->customer_name }}</td>
                                            <td>

                                                <a href="javascript: void(0);" class="text-reset">{{ $data->customer_contact_number }}</a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-1 text-muted fs-13">{{ date('d M Y',strtotime($data->ordered_date)) }}</div>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="avatar-group flex-nowrap">
                                                    <div class="avatar-group-item">
                                                        <a href="javascript: void(0);" class="d-inline-block">

                                                            @isset($data->orderProducts)
                                                            <ul>
                                                                @foreach ($data->orderProducts as $orderdata)
                                                                    <li>{{ isset($orderdata->product->name) ? $orderdata->product->name : '' }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endisset
                                                        </a>
                                                    </div>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-1 text-muted fs-13">{{ $data->trailer->name}}</div>

                                                </div>
                                            </td>
                                            <td class="text-muted">06 Sep 2021</td>
                                        </tr><!-- end tr -->
                                        @endforeach


                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div>
                            <div class="mt-3 text-center">
                                <a href="{{ route('admin.order.index') }}" class="text-muted text-decoration-underline">View All</a>
                            </div>

                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-5">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1 py-1">Customers ({{ $customers->count() }})</h4>
                            <div class="flex-shrink-0">
                                <div class="dropdown card-header-dropdown">

                                </div>
                            </div>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-borderless table-nowrap table-centered align-middle mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Contact Number</th>
                                            <th scope="col">Source</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                    <tbody>
                                        @foreach ($customers->paginate(5) as $customer)


                                        <tr>
                                            <td>
                                                <div class="form-check">

                                                    <label class="form-check-label ms-1" for="checkTask1">
                                                        {{ $customer->customer_name }}
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-muted">{{ $customer->customer_contact_number }}</td>
                                            <td><span class="badge badge-soft-success">{{ $customer->source }}</span></td>

                                        </tr><!-- end -->
                                        @endforeach
                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div>
                            <div class="mt-3 text-center">
                                <a href="{{ route('admin.customer.index') }}" class="text-muted text-decoration-underline">View All</a>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->


        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
