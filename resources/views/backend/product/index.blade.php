@extends('admin.layouts.main')

@php $title =  'Measurement Lists | Admin Panel'; @endphp

@section('content')
    <!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Products List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Products</a></li>
                                <li class="breadcrumb-item active">Products List</li>
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
                                <h5 class="card-title mb-0 flex-grow-1">All Products Info</h5>
                                <div class="flex-shrink-0">
                                    <div class="d-flex flex-wrap gap-2">
                                        @if (request('product_category'))
                                            <a href="{{ route('admin.product.create', ['product_category' => request('product_category')]) }}"
                                                class="btn btn-danger add-btn"><i class="ri-add-line align-bottom me-1"></i>
                                                Create Products</a>
                                        @else
                                            <a href="{{ route('admin.product.create') }}" class="btn btn-danger add-btn"><i
                                                    class="ri-add-line align-bottom me-1"></i> Create Products</a>
                                        @endif



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
                                            <th class="sort" data-sort="tasks_name">Image</th>
                                            <th class="sort" data-sort="tasks_name">Category</th>
                                            <th class="sort" data-sort="tasks_name">Product Name</th>
                                            <th class="sort" data-sort="tasks_name">Pattern</th>
                                            {{-- <th class="sort" data-sort="tasks_name">Measurement</th> --}}
                                            <th class="sort" data-sort="assignedto">price</th>
                                            <th class="sort" data-sort="due_date">Action</th>

                                        </tr>
                                        <form id="searchForm" action="{{ route('admin.product.index') }}" method="GET">
                                            <tr>
                                                <th></th>
                                                <th></th>

                                                <th>
                                                    <select id="categorySearch" name="product_category" class="form-select">
                                                        <option value="">Product Category</option>
                                                        @foreach ($categorys as $category)
                                                            @php
                                                                $subcategorys = $category->getSubCategories(
                                                                    $category->id,
                                                                );
                                                            @endphp
                                                            @if (count($subcategorys) > 0)
                                                                <optgroup label="{{ $category->name }}">

                                                                    @foreach ($subcategorys as $subcategory)
                                                                        @php
                                                                            $tcategorys = $subcategory->getSubCategories(
                                                                                $subcategory->id,
                                                                            );
                                                                        @endphp
                                                                        @if (count($tcategorys) > 0)
                                                                <optgroup label="{{ $subcategory->name }}">

                                                                    @foreach ($tcategorys as $data)
                                                                        <option value="{{ $data->id }}"
                                                                            {{ $data->id == request('product_category') ? 'selected' : '' }}>
                                                                            {{ $data->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @else
                                                                <option value="{{ $subcategory->id }}"
                                                                    {{ $subcategory->id == request('product_category') ? 'selected' : '' }}>
                                                                    {{ $subcategory->name }}</option>
                                                            @endif
                                                        @endforeach
                                                        </optgroup>
                                                    @else
                                                        <option value="{{ $category->id }}"
                                                            {{ $category->id == request('product_category') ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                        @endif
                                                        @endforeach

                                                    </select>
                                                </th>

                                                <th><input type="text" id="sizeSearch" name="product_name"
                                                        class="form-control" placeholder="Search product"
                                                        value="{{ request('product_name') }}"></th>
                                                <th>
                                                    <select id="patternSearch" name="pattern" class="form-select select2"
                                                        onchange="submit()">
                                                        <option value="">Product Pattern</option>
                                                        @foreach ($patterns as $pattern)
                                                            <option value="{{ $pattern->id }}"
                                                                {{ $pattern->id == request('pattern') ? 'selected' : '' }}>
                                                                {{ $pattern->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </th>
                                                {{-- <th>
                                                    <select id="measurementSearch" name="measurement" class="form-control">
                                                        <option value="">Product measurement</option>
                                                        @foreach ($measurements as $measurement)
                                                            <option value="{{ $measurement->id }}"
                                                                {{ $measurement->id == request('measurement') ? 'selected' : '' }}>
                                                                {{ $measurement->size }}</option>
                                                        @endforeach
                                                    </select>
                                                </th> --}}
                                                {{-- <th>Price</th> --}}
                                                <th></th>
                                                <th></th>

                                                <th></th> <!-- eave this column empty for Action column -->
                                            </tr>
                                        </form>

                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($products as $item)
                                            <tr>
                                                <td class="id">{{ $loop->index + 1 }}</td>
                                                <td class="id">
                                                    @if ($item->image)
                                                        <img id="image-preview"
                                                            src="{{ asset('images/product/' . $item->image) }}"
                                                            alt="Image Preview" style="max-width: 120px; height: 120px;">
                                                    @else
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 tasks_name">
                                                            {{ isset($item->category->name) ? $item->category->name : null }}
                                                        </div>

                                                    </div>
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $item->name }}</a></td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ isset($item->pattern->name) ? $item->pattern->name : '' }}</a>
                                                </td>

                                                {{-- <td class="project_name"><a
                                                        class="fw-medium link-primary">{{isset( $item->measurement->size) ?  $item->measurement->size : null }}</a>
                                                </td> --}}
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $item->price }}</a></td>
                                                <td class="assignedto">
                                                    <a href="{{ route('admin.product.edit', $item->id) }}"
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
                                @if ($products->count() == 0)
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
            @foreach ($products as $user)
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
                                        <form method="POST" action="{{ route('admin.product.delete', $user->id) }}"
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
    <script>
        // Get the form element
        const searchForm = document.getElementById('searchForm');

        // Add event listeners to input fields and select element
        document.getElementById('categorySearch').addEventListener('change', submitForm);
        document.getElementById('sizeSearch').addEventListener('keypress', handleEnter);
        document.getElementById('patternSearch').addEventListener('change', submitForm);
        document.getElementById('measurementSearch').addEventListener('change', submitForm);

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
            top: 8px;
        }
    </style>
@endsection
