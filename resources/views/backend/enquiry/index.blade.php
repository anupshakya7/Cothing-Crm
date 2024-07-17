@extends('admin.layouts.main')

@php $title =  'Enquiry Lists | Admin Panel'; @endphp

@section('content')
    <!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Enquiry List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.enquiry.index') }}">Enquiry</a></li>
                                <li class="breadcrumb-item active">Enquiry List</li>
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
                                <h5 class="card-title mb-0 flex-grow-1">All Enquiry Info</h5>
                                <div class="flex-shrink-0">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('admin.enquiry.create') }}" class="btn btn-danger add-btn"><i
                                                class="ri-add-line align-bottom me-1"></i> Create Enquiry</a>
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
                                            <th class="sort" data-sort="tasks_name">Source</th>
                                            <th class="sort" data-sort="tasks_name">Priority</th>
                                            <th class="sort" data-sort="tasks_name">status</th>
                                            <th class="sort" data-sort="tasks_name">Handled By</th>
                                            <th class="sort" data-sort="due_date">Action</th>

                                        </tr>
                                        <form id="searchForm" action="{{ route('admin.enquiry.index') }}" method="GET">
                                            <tr>
                                                <th></th>
                                                <th><input type="text" id="sizeSearch" name="name"
                                                        class="form-control" placeholder="Search name"
                                                        value="{{ request('name') }}"></th>
                                                <th><input type="text" id="contactSearch" name="contact_number"
                                                        class="form-control" placeholder="Search contact number"
                                                        value="{{ request('contact_number') }}"></th>
                                                <th>
                                                    <select class="form-select" id="sourceSearch" name="source"
                                                        data-choices data-choices-search-false
                                                        name="choices-single-default2">
                                                        <option value="">Select Source Type</option>
                                                        <option value="Call"
                                                            {{ request('source') == 'Call' ? 'selected' : '' }}>Call
                                                        </option>
                                                        <option value="Online"
                                                            {{ request('source') == 'Online' ? 'selected' : '' }}>Online
                                                        </option>

                                                    </select>

                                                <th>
                                                    <select class="form-select" name="priority" id="prioritySearch"
                                                        data-choices data-choices-search-false
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
                                                        <option value="Completed"
                                                            {{ request('status') == 'Completed' ? 'selected' : '' }}>
                                                            Completed</option>

                                                    </select>
                                                </th>



                                                <th>
                                                    <select class="form-select" id="handleSearch" name="handle_by"
                                                        data-choices data-choices-search-false
                                                        name="choices-single-default2">
                                                        <option value="">Select Handle by</option>
                                                        @foreach ($handle_bys as $hanlde_by)
                                                            <option value="{{ $hanlde_by->id }}"
                                                                {{ request('handle_by') == $hanlde_by->id ? 'selected' : '' }}>
                                                                {{ $hanlde_by->name }}</option>
                                                        @endforeach



                                                    </select>
                                                </th>
                                                <th></th> <!-- Leave this column empty for Action column -->
                                            </tr>
                                        </form>

                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($enquirys as $item)
                                            <tr>
                                                <td class="id">{{ $loop->index + 1 }}</td>

                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 tasks_name">{{ $item->name }}
                                                        </div>

                                                    </div>
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $item->mobile }}</a></td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $item->source_type }}</a></td>

                                                <td class="project_name">
                                                    @php
                                                        $priorityClass = '';
                                                        switch ($item->priority) {
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
                                                        class="fw-medium link-primary btn {{ $priorityClass }}">{{ $item->priority }}</a>
                                                </td>
                                                <td class="project_name">
                                                    <a class="fw-medium link-primary btn btn-default"
                                                        style="
                                                        @if ($item->status == 'Completed') background-color: green;
                                                        @elseif($item->status == 'Pending') background-color: yellow; color:gray !important;
                                                        @elseif($item->status == 'Inprogress') background-color: orange; @endif">
                                                        {{ $item->status }}
                                                    </a>
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $item->user->name }}</a></td>
                                                <td class="assignedto">
                                                    <a href="{{ route('admin.enquiry.followup', $item->id) }}"
                                                        class="btn btn-outline-warning">Followup-details</a>
                                                    @if ($item->status != 'Completed')
                                                        <a href="{{ route('admin.enquiry.customer', $item->id) }}"
                                                            class="btn btn-outline-dark">Make Customer</a>
                                                    @endif
                                                    <a href="{{ route('admin.enquiry.edit', $item->id) }}"
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
                                @if ($enquirys->count() == 0)
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



                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
            @foreach ($enquirys as $user)
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
                                        <form method="POST" action="{{ route('admin.enquiry.delete', $user->id) }}"
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


    <!-- End Page-content -->
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

        // Add event listeners to input fields
        document.getElementById('sizeSearch').addEventListener('keypress', handleEnter);
        document.getElementById('contactSearch').addEventListener('keypress', handleEnter);
        document.getElementById('sourceSearch').addEventListener('change', submitForm);
        document.getElementById('prioritySearch').addEventListener('change', submitForm);
        document.getElementById('statusSearch').addEventListener('change', submitForm);
        document.getElementById('handleSearch').addEventListener('change', submitForm);

        // Function to submit the form when Enter is pressed in input fields
        function handleEnter(event) {
            if (event.key === 'Enter') {
                submitForm();
            }
        }

        // Function to submit the form
        function submitForm() {
            searchForm.submit();
        }
    </script>
@endsection
