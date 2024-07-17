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
                            <h4 class="mb-sm-0">Suppliers Order List</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.index') }}">Suppliers Order</a></li>
                                    <li class="breadcrumb-item active">Suppliers Order List</li>
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
                                    <h5 class="card-title mb-0 flex-grow-1">All Supliers Order  Info</h5>
                                    <div class="flex-shrink-0">
                                       <div class="d-flex flex-wrap gap-2">
                                            @if(request('vendor'))
                                            <a href="{{ route('admin.suppliers.create',['vendor'=>request('vendor')]) }}" class="btn btn-danger add-btn" ><i class="ri-add-line align-bottom me-1"></i> Create supplier order</a>
                                            @else
                                                <a href="{{ route('admin.suppliers.create') }}" class="btn btn-danger add-btn" ><i class="ri-add-line align-bottom me-1"></i> Create supplier order</a>
                                            @endif
                                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                       </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card-body">
                                <div class="table-responsive table-card mb-4">
                                    <table class="table align-middle table-nowrap mb-0" id="tasksTable">
                                        <thead class="table-light text-muted">
                                            <tr>

                                                <th class="sort" data-sort="project_name">S.N</th>
                                                <th class="sort" data-sort="tasks_name">Vendor Name</th>
                                                <th class="sort" data-sort="category_name">Categories</th>
                                                <th class="sort" data-sort="subcategory_name">Sub Categories</th>
                                                <th class="sort" data-sort="tasks_name">Items</th>
                                                <th class="sort" data-sort="client_name">qty</th>
                                                <th class="sort" data-sort="assignedto">rate</th>
                                                <th class="sort" data-sort="assignedto">Date</th>
                                                <th class="sort" data-sort="assignedto">confirmed By</th>
                                                <th class="sort" data-sort="due_date">Action</th>

                                            </tr>
                                            <form id="searchForm" action="{{ route('admin.suppliers.index') }}" method="GET">

                                            <tr>
                                                <th></th>

                                                <th>
                                                    <select id="categorySearch" name="vendor"
                                                        class="form-select">
                                                        <option value="">Select Vendor</option>
                                                        @foreach ($vendors as $vendor)
                                                            <option value="{{ $vendor->id }}"
                                                                {{ $vendor->id == request('vendor') ? 'selected' : '' }}>
                                                                {{ $vendor->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </th>
                                                <th>
                                                   <!-- <select id="patternSearch" name="category" class="form-select">
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $pattern)
                                                            <option value="{{ $pattern->id }}"
                                                                {{ $pattern->id == request('category') ? 'selected' : '' }}>
                                                                {{ $pattern->name }}</option>
                                                        @endforeach
                                                    </select>-->
                                                </th>
                                                <th></th>
                                                <th>
                                                   <!-- <select id="patternSearch" name="item" class="form-select">
                                                        <option value="">Select Item</option>
                                                        @foreach ($items as $pattern)
                                                            <option value="{{ $pattern->id }}"
                                                                {{ $pattern->id == request('item') ? 'selected' : '' }}>
                                                                {{ $pattern->name }}</option>
                                                        @endforeach
                                                    </select>-->
                                                </th>

                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>

                                                <th></th> <!-- eave this column empty for Action column -->
                                            </tr>
                                            </form>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($suppliers as $supplier)
                                            <tr>
                                                <td class="id">{{ $loop->index + 1 }}</td>

                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 tasks_name"><a href="{{route('admin.suppliers.detail', ['vendor'=>$supplier->vendor_id,'date_type'=> 'Custom'])}}" class="fw-bold"> {{$supplier->vendor->name }}</a></div>

                                                    </div>
                                                </td>
                                                <td class="id">
                                                    @if(isset($supplier->OrderItem))
                                                    <ul>
                                                        @foreach ($supplier->OrderItem as $data)
                                                        @if(isset($data->Category->parentCategory))
                                                            <li>{{$data->Category->parentCategory->name}}</li>
                                                        @endif
                                                        @endforeach
                                                    </ul>  
                                                    @endif
                                                </td>
                                                <td class="id">
                                                    @if(isset($supplier->OrderItem))
                                                    <ul>
                                                        @foreach ($supplier->OrderItem as $data)
                                                        @if(isset($data->Category))
                                                            <li>{{$data->Category->name}}</li>
                                                        @endif
                                                        @endforeach
                                                    </ul>  
                                                    @endif
                                                </td>
                                                <td class="id">
                                                    @if(isset($supplier->OrderItem))
                                                    <ul>
                                                        @foreach ($supplier->OrderItem as $data)
                                                            <li>{{$data->Item->name}}</li>
                                                        @endforeach
                                                    </ul>  
                                                    @endif
                                                </td>

                                                <td class="project_name">
                                                    @isset($supplier->OrderItem)
                                                        <ul>
                                                            @foreach ($supplier->OrderItem as $data)
                                                                <li>{{$data->qty}}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endisset
                                                </td>
                                                <td class="project_name">
                                                    @isset($supplier->OrderItem)
                                                        <ul>
                                                            @foreach ($supplier->OrderItem as $data)
                                                                <li>{{$data->price}}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endisset
                                                </td>
                                                <td class="project_name"><a  class="fw-medium link-primary">{{ $supplier->date }}</a></td>
                                                <td class="project_name"><a  class="fw-medium link-primary">{{ $supplier->user->name }}</a></td>

                                                <td class="assignedto">
                                                    <a href="{{ route('admin.suppliers.detail', ['vendor'=>$supplier->vendor_id,'date_type'=> 'Custom']) }}" class="btn btn-outline-success">Details</a>
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" href="#deleteOrder{{$supplier->id}}">
                                                        Delete
                                                    </button>
                                                </td>

                                            </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                    <!--end table-->
                                    @if($suppliers->count() == 0)
                                    <div class="noresult mt-3">
                                        <div class="text-center">
                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
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
                @foreach ($suppliers as $user)
                <div class="modal fade flip" id="deleteOrder{{$user->id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4>You are about to delete a supplier order ?</h4>
                                    <p class="text-muted fs-14 mb-4">Deleting your supplier order will remove all of
                                        your information from our database.</p>

                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link btn-ghost-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <form method="POST" action="{{ route('admin.suppliers.delete.all', $user->vendor_id) }}" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                        <button type="submit" class="btn btn-danger" id="delete-record">Yes, Delete It</button>
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

