@extends('admin.layouts.main')

@php $title =  'Order Report | Admin Panel'; @endphp

@section('content')
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Order Reports</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.order.report', ['date_type' => 'Custom']) }}">Orders</a></li>
                                <li class="breadcrumb-item active">Order Report</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->


            <div class="row ">
                <div class="col-lg-12">
                    <div class="card" id="tasksList">
                        <div class="card-header">
                            <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::input('date_type') == 'Custom' ? 'active' : '' }} py-3 Completed"
                                        id="Completed" href="{{ route('admin.order.report', ['date_type' => 'Custom']) }}"
                                        role="tab"
                                        aria-selected="{{ Request::input('date_type') == 'Custom' ? 'true' : 'false' }}">
                                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Custom
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{ Request::input('date_type') == 'Daily' ? 'active' : '' }} py-3"
                                        id="All" href="{{ route('admin.order.report', ['date_type' => 'Daily']) }}"
                                        role="tab"
                                        aria-selected="{{ Request::input('date_type') == 'Daily' ? 'true' : 'false' }}">
                                        <i class="ri-store-2-fill me-1 align-bottom"></i> Daily
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::input('date_type') == 'Weekly' ? 'active' : '' }} py-3 Pickups"
                                        id="Pickups" href="{{ route('admin.order.report', ['date_type' => 'Weekly']) }}"
                                        role="tab"
                                        aria-selected="{{ Request::input('date_type') == 'Weekly' ? 'true' : 'false' }}">
                                        <i class="ri-truck-line me-1 align-bottom"></i> Weekly
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::input('date_type') == 'Monthly' ? 'active' : '' }} py-3 Pending"
                                        id="Pending" href="{{ route('admin.order.report', ['date_type' => 'Monthly']) }}"
                                        role="tab"
                                        aria-selected="{{ Request::input('date_type') == 'Monthly' ? 'true' : 'false' }}">
                                        <i class="ri-record-circle-line me-1 align-bottom"></i> Monthly
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::input('date_type') == 'Yearly' ? 'active' : '' }} py-3 Delivered"
                                        id="Delivered" href="{{ route('admin.order.report', ['date_type' => 'Yearly']) }}"
                                        role="tab"
                                        aria-selected="{{ Request::input('date_type') == 'Yearly' ? 'true' : 'false' }}">
                                        <i class="ri-file-list-fill me-1 align-bottom"></i> Yearly
                                    </a>
                                </li>



                            </ul>
                            @if (Request::input('date_type') == 'Daily')
                                <div class="d-flex align-items-center">
                                    <div class="card-title flex-grow-1 mb-0">
                                        <form id="ordersearchForm" action="{{ route('admin.order.report') }}"
                                            method="GET" class="row g-3 align-items-center">
                                            <input type="hidden" name="date_type"
                                                value="{{ Request::input('date_type', 'Daily') }}">
                                            <div class="row">

                                                <div class="col-auto">
                                                    <label for="fromDate" class="col-form-label">Select Date</label>
                                                    <input type="text" name="daily_date" id="daily_date"
                                                        class="form-control" placeholder="Daily Date"
                                                        value="{{ request('daily_date', $daily_date) }}">
                                                </div>

                                                <div class="col-auto">
                                                    <label for="tabsearch" class="col-form-label">&nbsp;</label>
                                                    <input type="submit" class="form-control btn btn-primary"
                                                        value="Search">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            @endif
                            @if (Request::input('date_type') == 'Weekly')
                            <div class="text-center mt-4">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <a href="{{ route('admin.order.report', ['date_type' => Request::input('date_type', 'Weekly'), 'weekOffset' => $weekOffset - 1]) }}" class="btn btn-outline-primary">Previous Week</a>
                                    </div>
                                    <div class="col">
                                        <span class="font-weight-bold">{{ $startOfWeek_day }} to {{ $endOfWeek_day }}</span>
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('admin.order.report', ['date_type' => Request::input('date_type', 'Weekly'), 'weekOffset' => $weekOffset + 1]) }}" class="btn btn-outline-primary">Next Week</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                            @if (Request::input('date_type') == 'Monthly')
                                <div class="d-flex align-items-center">
                                    <div class="card-title flex-grow-1 mb-0">
                                        <form id="ordersearchForm" action="{{ route('admin.order.report') }}"
                                            method="GET" class="row g-3 align-items-center">
                                            <input type="hidden" name="date_type"
                                                value="{{ Request::input('date_type', 'Monthly') }}">
                                            <div class="row">

                                                <div class="col-auto">
                                                    <label for="fromDate" class="col-form-label">Select Year</label>
                                                    <select name="year_date" class="form-select select2 me-2" required>
                                                        <option value="">Select Year</option>
                                                        @for ($year = $last_year; $year >= 2065; $year--)
                                                            @if (request('year_date', $year_date))
                                                                <option value="{{ $year }}"
                                                                    {{ $year_date == $year ? 'selected' : '' }}>
                                                                    {{ $year }}
                                                                </option>
                                                            @else
                                                                <option value="{{ $year }}"
                                                                    {{ $last_year == $year ? 'selected' : '' }}>
                                                                    {{ $year }}
                                                                </option>
                                                            @endif
                                                        @endfor
                                                    </select>


                                                </div>


                                                <div class="col-auto ">
                                                    <label for="fromDate" class="col-form-label">Select Month</label>
                                                    <select name="month_date" class="form-select select2 me-2" required>
                                                        <option value="">Select Month</option>

                                                        <option value="01"
                                                            {{ $month_date == '01' ? 'selected' : '' }}>Baishak</option>
                                                        <option value="02"
                                                            {{ $month_date == '02' ? 'selected' : '' }}>Jesth</option>
                                                        <option value="03"
                                                            {{ $month_date == '03' ? 'selected' : '' }}>Asar</option>
                                                        <option value="04"
                                                            {{ $month_date == '04' ? 'selected' : '' }}>Shrawan</option>
                                                        <option value="05"
                                                            {{ $month_date == '05' ? 'selected' : '' }}>Bhadra</option>
                                                        <option value="06"
                                                            {{ $month_date == '06' ? 'selected' : '' }}>Ashoj</option>
                                                        <option value="07"
                                                            {{ $month_date == '07' ? 'selected' : '' }}>Kartik</option>
                                                        <option value="08"
                                                            {{ $month_date == '08' ? 'selected' : '' }}>Mangsir</option>
                                                        <option value="09"
                                                            {{ $month_date == '09' ? 'selected' : '' }}>Poush</option>
                                                        <option value="10"
                                                            {{ $month_date == '10' ? 'selected' : '' }}>Magh</option>
                                                        <option value="11"
                                                            {{ $month_date == '11' ? 'selected' : '' }}>Falgun</option>
                                                        <option value="12"
                                                            {{ $month_date == '12' ? 'selected' : '' }}>Chaitra</option>
                                                    </select>
                                                </div>

                                                <div class="col-auto mt-2">
                                                    <label for="tabsearch" class="col-form-label">&nbsp;</label>
                                                    <input type="submit" class="form-control btn btn-primary"
                                                        value="Search">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            @endif

                            @if (Request::input('date_type') == 'Yearly')
                                <div class="d-flex align-items-center">
                                    <div class="card-title flex-grow-1 mb-0">
                                        <form id="ordersearchForm" action="{{ route('admin.order.report') }}"
                                            method="GET" class="row g-3 align-items-center">
                                            <input type="hidden" name="date_type"
                                                value="{{ Request::input('date_type', 'Yearly') }}">
                                            <div class="row">

                                                <div class="col-auto">
                                                    <label for="fromDate" class="col-form-label">Select Year</label>
                                                    <select name="year_date" class="form-select select2 me-2">
                                                        <option value="">Select Year</option>
                                                        @for ($year = $last_year; $year >= 2065; $year--)
                                                            @if (request('year_date', $year_date))
                                                                <option value="{{ $year }}"
                                                                    {{ $year_date == $year ? 'selected' : '' }}>
                                                                    {{ $year }}
                                                                </option>
                                                            @else
                                                                <option value="{{ $year }}"
                                                                    {{ $last_year == $year ? 'selected' : '' }}>
                                                                    {{ $year }}
                                                                </option>
                                                            @endif
                                                        @endfor
                                                    </select>


                                                </div>

                                                <div class="col-auto">
                                                    <label for="tabsearch" class="col-form-label">&nbsp;</label>
                                                    <input type="submit" class="form-control btn btn-primary"
                                                        value="Search">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            @endif

                            @if (Request::input('date_type') == 'Custom')
                                <div class="d-flex align-items-center">
                                    <div class="card-title flex-grow-1 mb-0">
                                        <form id="ordersearchForm" action="{{ route('admin.order.report') }}"
                                            method="GET" class="row g-3 align-items-center">
                                            <input type="hidden" name="date_type"
                                                value="{{ Request::input('date_type', 'Custom') }}">
                                            <div class="row">

                                                <div class="col-auto">
                                                    <label for="fromDate" class="col-form-label">From Date</label>
                                                    <input type="text" id="fromDate" name="fromDate"
                                                        class="form-control" placeholder="From Date"
                                                        value="{{ request('fromDate') }}">
                                                </div>
                                                <div class="col-auto">
                                                    <label for="toDate" class="col-form-label">To Date</label>
                                                    <input type="text" id="toDate" name="toDate"
                                                        class="form-control" placeholder="To Date"
                                                        value="{{ request('toDate') }}">
                                                </div>
                                                <div class="col-auto">
                                                    <label for="tabsearch" class="col-form-label">&nbsp;</label>
                                                    <input type="submit" class="form-control btn btn-primary"
                                                        value="Search">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            @endif

                        </div>


                        <div class="row project-wrapper">
                            <div class="col-xxl-12">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span
                                                            class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                                                            <i data-feather="briefcase" class="text-primary"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                            All Order
                                                        </p>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                    data-target="{{ $ordercount }}">{{ $ordercount > 40 ? $ordercount - 25 : 0 }}</span>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span
                                                            class="avatar-title bg-soft-warning text-warning rounded-2 fs-2">
                                                            <i data-feather="award" class="text-warning"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <p class="text-uppercase fw-medium text-muted mb-3">Inprogress</p>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                    data-target="{{ $inprogresscount }}">{{ $inprogresscount > 40 ? $inprogresscount - 25 : 0 }}</span>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info text-info rounded-2 fs-2">
                                                            <i data-feather="clock" class="text-info"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                            Hold
                                                        </p>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                    data-target="{{ $holdcount }}">{{ $holdcount > 40 ? $holdcount - 25 : 0 }}</span>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->


                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info text-info rounded-2 fs-2">
                                                            <i data-feather="clock" class="text-info"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                            Pending
                                                        </p>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                    data-target="{{ $pendingcount }}">{{ $pendingcount > 40 ? $pendingcount - 25 : 0 }}</span>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info text-info rounded-2 fs-2">
                                                            <i data-feather="clock" class="text-info"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                            Delivered
                                                        </p>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                    data-target="{{ $deliveredcount }}">{{ $deliveredcount > 40 ? $deliveredcount - 25 : 0 }}</span>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info text-info rounded-2 fs-2">
                                                            <i data-feather="clock" class="text-info"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                            Completed
                                                        </p>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                    data-target="{{ $completedcount }}">{{ $completedcount > 40 ? $completedcount - 25 : 0 }}</span>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info text-info rounded-2 fs-2">
                                                            <i data-feather="clock" class="text-info"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                            Returns
                                                        </p>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                    data-target="{{ $returncount }}">{{ $returncount > 40 ? $returncount - 25 : 0 }}</span>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-xl-3">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info text-info rounded-2 fs-2">
                                                            <i data-feather="clock" class="text-info"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden ms-3">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                            Cancelled
                                                        </p>
                                                        <div class="d-flex align-items-center mb-3">
                                                            <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                                    data-target="{{ $cancelledcount }}">{{ $cancelledcount > 40 ? $cancelledcount - 25 : 0 }}</span>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total Sales</p>
                                                    </div>

                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">Rs <span class="counter-value" data-target="{{ $total_sum }}">{{ $total_sum }}</span></h4>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                                            <i class="bx bx-dollar-circle text-success"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total Advance paid</p>
                                                    </div>

                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">Rs <span class="counter-value" data-target="{{ $advance_sum }}">{{ $advance_sum }}</span></h4>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                                            <i class="bx bx-dollar-circle text-success"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>


                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Receivable Amount</p>
                                                    </div>

                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">Rs <span class="counter-value" data-target="{{ $receivable_amount }}">{{ $receivable_amount }}</span></h4>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                                            <i class="bx bx-dollar-circle text-success"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>


                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Delivery Amount</p>
                                                    </div>

                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">Rs <span class="counter-value" data-target="{{ $delivery_amount }}">{{ $delivery_amount }}</span></h4>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                                            <i class="bx bx-dollar-circle text-success"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>

                                </div><!-- end row -->


                            </div><!-- end col -->


                        </div><!-- end row -->


                        <br>

                        <div class="card-body">
                            <div class="table-responsive table-card mb-4">

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
                                            <form id="searchForm" action="{{ route('admin.order.report') }}"
                                                method="GET">
                                                <input type="hidden" name="date_type"
                                                    value="{{ Request::input('date_type', 'Custom') }}">

                                                <tr>
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
                                                            <option value="Returned"
                                                                {{ request('status') == 'Returned' ? 'selected' : '' }}>
                                                                Returned</option>
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
                                {{ $orders->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
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
    <link rel="stylesheet" href="{{asset('assets/css/nepali-date-picker.css')}}">
    <script src="{{asset('assets/js/nepali-date-picker.js')}}"></script>

    <script type="text/javascript">
        window.onload = function() {

            var mainInput = document.getElementById("orderdateSearch");
            mainInput.nepaliDatePicker();

        };
    </script>

    @if (Request::input('date_type') == 'Custom')
        <script type="text/javascript">
            window.onload = function() {

                var mainInput1 = document.getElementById("fromDate");
                mainInput1.nepaliDatePicker();

                var mainInput2 = document.getElementById("toDate");
                mainInput2.nepaliDatePicker();


            };
        </script>
    @endif

    @if (Request::input('date_type') == 'Daily')
        <script type="text/javascript">
            window.onload = function() {
                var daily_date = document.getElementById("daily_date");
                daily_date.nepaliDatePicker();

            };
        </script>
    @endif



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
