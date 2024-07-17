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
                        <h4 class="mb-sm-0">Vendors List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Vendors</a></li>
                                <li class="breadcrumb-item active">Vendors List</li>
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
                                <h5 class="card-title mb-0 flex-grow-1">All Vendor Info</h5>
                                <div class="flex-shrink-0">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('admin.vendors.create') }}" class="btn btn-danger add-btn"><i
                                                class="ri-add-line align-bottom me-1"></i> Create Vendor</a>
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

                                            <th class="sort" data-sort="project_name">S.N</th>
                                            <th class="sort" data-sort="tasks_name">Name</th>
                                            <th class="sort" data-sort="tasks_name">Contact Number</th>
                                            <th class="sort" data-sort="client_name">Address</th>
                                            <th class="sort" data-sort="assignedto">status</th>
                                            <th class="sort" data-sort="due_date">Action</th>

                                        </tr>
                                        <form id="searchForm" action="{{ route('admin.vendors.index') }}" method="GET">
                                            <tr>
                                                <th></th>
                                                <th>
                                                    <div class="d-flex align-items-start">
                                                        <select name="filter_letter" class="form-select select2 me-4" onchange="this.form.submit()">
                                                            <option value="">Select Letter</option>
                                                            @foreach(range('A','Z') as $letter)
                                                                <option value="{{$letter}}" {{request('filter_letter') == $letter ? 'selected':''}}>  
                                                                {{$letter}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="text" id="sizeSearch" name="name"
                                                        class="form-control ms-2" placeholder="Search vendor"
                                                        value="{{ request('name') }}">
                                                    </div>
                                                </th>
                                                <th><input type="text" id="numberSearch" name="contact"
                                                        class="form-control mb-2" placeholder="Search contact"
                                                        value="{{ request('contact') }}"></th>
                                                <th></th>
                                                <th></th>

                                                <th></th> <!-- eave this column empty for Action column -->
                                            </tr>
                                        </form>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($vendors as $vendor)
                                            <tr>
                                                <td class="id">{{ $loop->index + 1 }}</td>

                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 tasks_name">
                                                            <a href="{{route('admin.suppliers.index',['vendor'=>$vendor->id])}}" class="fw-bold">
                                                                {{ $vendor->name }}
                                                            </a>
                                                        </div>

                                                    </div>
                                                </td>

                                                <td class="id"><a href="#"
                                                        class="fw-medium link-primary">{{ $vendor->contact_number }}</a>
                                                </td>

                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $vendor->address }}</a></td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $vendor->status }}</a></td>

                                                <td class="assignedto">
                                                    <a href="{{ route('admin.vendors.edit', $vendor->id) }}"
                                                        class="btn btn-outline-success">Edit</a>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-bs-toggle="modal" href="#deleteOrder{{ $vendor->id }}">
                                                        Delete
                                                    </button>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                                <!--end table-->
                                @if($vendor->count() == 0)
                                <div class="noresult">
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
            @foreach ($vendors as $user)
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
                                        <form method="POST" action="{{ route('admin.vendors.delete', $user->id) }}"
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
    <script>
        // Get the form element
        const searchForm = document.getElementById('searchForm');

        // Add event listeners to input fields and select element
        document.getElementById('sizeSearch').addEventListener('keypress', handleEnter);
        document.getElementById('numberSearch').addEventListener('keypress', handleEnter);


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
