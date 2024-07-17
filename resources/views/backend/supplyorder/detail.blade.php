@extends('admin.layouts.main')

@php $title =  'User Lists | Admin Panel'; @endphp

@section('content')
    <!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{$vendor->name}} Order List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.index') }}">Suppliers Order</a>
                                </li>
                                <li class="breadcrumb-item active">{{$vendor->name}} Order List</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="tasksList">
                        <div class="card-header">
                            <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::input('date_type') == 'Custom' ? 'active' : '' }} py-3 Completed"
                                        id="Completed" href="{{ route('admin.suppliers.detail', ['vendor'=>request('vendor'),'date_type' => 'Custom']) }}"
                                        role="tab"
                                        aria-selected="{{ Request::input('date_type') == 'Custom' ? 'true' : 'false' }}">
                                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Custom
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::input('date_type') == 'Monthly' ? 'active' : '' }} py-3 Pending"
                                        id="Pending" href="{{ route('admin.suppliers.detail', ['vendor'=>request('vendor'),'date_type' => 'Monthly']) }}"
                                        role="tab"
                                        aria-selected="{{ Request::input('date_type') == 'Monthly' ? 'true' : 'false' }}">
                                        <i class="ri-record-circle-line me-1 align-bottom"></i> Monthly
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::input('date_type') == 'Yearly' ? 'active' : '' }} py-3 Delivered"
                                        id="Delivered" href="{{ route('admin.suppliers.detail', ['vendor'=>request('vendor'),'date_type' => 'Yearly']) }}"
                                        role="tab"
                                        aria-selected="{{ Request::input('date_type') == 'Yearly' ? 'true' : 'false' }}">
                                        <i class="ri-file-list-fill me-1 align-bottom"></i> Yearly
                                    </a>
                                </li>
                            </ul>
                            @if (Request::input('date_type') == 'Monthly')
                                <div class="d-flex align-items-center">
                                    <div class="card-title flex-grow-1 mb-0">
                                        <form id="ordersearchForm" action="{{ route('admin.suppliers.detail') }}"
                                            method="GET" class="row g-3 align-items-center">
                                            <input type="hidden" name="vendor"
                                            value="{{ Request::input('vendor') }}">
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

                            @if (Request::input('date_type') == 'Yearly')
                                <div class="d-flex align-items-center">
                                    <div class="card-title flex-grow-1 mb-0">
                                        <form id="ordersearchForm" action="{{ route('admin.suppliers.detail') }}"
                                            method="GET" class="row g-3 align-items-center">
                                            <input type="hidden" name="vendor"
                                                value="{{ Request::input('vendor') }}">
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
                                        <form id="supplierOrderSearchForm" action="{{ route('admin.suppliers.detail') }}"
                                            method="GET" class="row g-3 align-items-center">
                                            <input type="hidden" name="vendor"
                                                value="{{ Request::input('vendor') }}">
                                            <input type="hidden" name="date_type"
                                                value="{{ Request::input('date_type') }}">
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
                        <div class="card-body">
                            <div class="table-responsive table-card mb-4">
                                <table class="table align-middle table-nowrap mb-0" id="tasksTable">
                                    <thead class="table-light text-muted">
                                        <tr>

                                            <th class="sort" data-sort="project_name">S.N</th>
                                            {{-- <th class="sort" data-sort="tasks_name">Vendor Name</th> --}}
                                            <th class="sort" data-sort="category_name">Categories</th>
                                            <th class="sort" data-sort="subcategory_name">Sub Categories</th>
                                            <th class="sort" data-sort="tasks_name">Items</th>
                                            <th class="sort" data-sort="client_name">qty</th>
                                            <th class="sort" data-sort="assignedto">rate</th>
                                            <th class="sort" data-sort="assignedto">Date</th>
                                            <th class="sort" data-sort="assignedto">confirmed By</th>
                                            <th class="sort" data-sort="due_date">Action</th>

                                        </tr>
                                        {{-- <form id="searchForm" action="{{ route('admin.suppliers.index') }}" method="GET">

                                            <tr>
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
                                        </form> --}}
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($vendor->SupplyOrders as $supplier)
                                            <tr>
                                                <td class="id">{{ $loop->index + 1 }}</td>

                                                {{-- <td>
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 tasks_name">{{ $supplier->vendor->name }}
                                                        </div>

                                                    </div>
                                                </td> --}}
                                                <td class="id">
                                                    @if (isset($supplier->OrderItem))
                                                        <ul>
                                                            @foreach ($supplier->OrderItem as $data)
                                                                @if (isset($data->Category->parentCategory))
                                                                    <li>{{ $data->Category->parentCategory->name }}</li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </td>
                                                <td class="id">
                                                    @if (isset($supplier->OrderItem))
                                                        <ul>
                                                            @foreach ($supplier->OrderItem as $data)
                                                                @if (isset($data->Category))
                                                                    <li>{{ $data->Category->name }}</li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </td>
                                                <td class="id">
                                                    @if (isset($supplier->OrderItem))
                                                        <ul>
                                                            @foreach ($supplier->OrderItem as $data)
                                                                <li>{{ $data->Item->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </td>

                                                <td class="project_name">
                                                    @isset($supplier->OrderItem)
                                                        <ul>
                                                            @foreach ($supplier->OrderItem as $data)
                                                                <li>{{ $data->qty }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endisset
                                                </td>
                                                <td class="project_name">
                                                    @isset($supplier->OrderItem)
                                                        <ul>
                                                            @foreach ($supplier->OrderItem as $data)
                                                                <li>{{ $data->price }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endisset
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $supplier->date }}</a></td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $supplier->user->name }}</a></td>

                                                <td class="assignedto">
                                                    <a href="{{ route('admin.suppliers.edit', $supplier->id) }}"
                                                        class="btn btn-outline-success">Edit</a>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-bs-toggle="modal" href="#deleteOrder{{ $supplier->id }}">
                                                        Delete
                                                    </button>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                                <!--end table-->
                                @if ($vendor->SupplyOrders->count() == 0)
                                    <div class="noresult mt-3">
                                        <div class="text-center">
                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                colors="primary:#121331,secondary:#08a88a"
                                                style="width:75px;height:75px"></lord-icon>
                                            <h5 class="mt-2">Sorry! No Result Found</h5>
                                        </div>
                                    </div>
                                @endif
                            </div>


                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
            @foreach ($vendor->SupplyOrders as $user)
                <div class="modal fade flip" id="deleteOrder{{ $user->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                    colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4>You are about to delete a supplier order ?</h4>
                                    <p class="text-muted fs-14 mb-4">Deleting your supplier order will remove all of
                                        your information from our database.</p>

                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link btn-ghost-success fw-medium text-decoration-none"
                                            id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <form method="POST" action="{{ route('admin.suppliers.delete', $user->id) }}"
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
    <!-- End Page-content -->


    <!-- end main content-->

    <script>
        // Get the form element
        const searchForm = document.getElementById('searchForm');

        // Add event listeners to input fields and select element
        document.getElementById('categorySearch').addEventListener('change', submitForm);
        document.getElementById('patternSearch').addEventListener('change', submitForm);

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
@endsection
@section('scripts')
@if(Request::input('date_type') == 'Custom')
<script type="text/javascript">
    window.onload = function(){
        var mainInput1 = document.getElementById("fromDate");
        mainInput1.nepaliDatePicker();

        var mainInput2 = document.getElementById("toDate");
        mainInput2.nepaliDatePicker();
    }
</script>
@endif
@endsection