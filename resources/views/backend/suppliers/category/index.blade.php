@extends('admin.layouts.main')

@php $title =  'Supply Category Lists | Admin Panel'; @endphp

@section('content')


    <!-- ============================================================== -->

        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">{{$type==2 ? 'Sub':''}} Category List</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Supply {{$type==2 ? 'Sub':''}} Category</a></li>
                                    <li class="breadcrumb-item active">{{$type==2 ? 'Sub':''}} Category List</li>
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
                                    <h5 class="card-title mb-0 flex-grow-1">All {{$type==2 ? 'Sub':''}} Category Info</h5>
                                    <div class="flex-shrink-0">
                                       <div class="d-flex flex-wrap gap-2">
                                        @if(request('category'))
                                            <a href="{{ route('admin.items-category.create',['type'=>$type,'category'=>request('category')]) }}" class="btn btn-danger add-btn" ><i class="ri-add-line align-bottom me-1"></i> Create {{$type==2 ? 'Sub':''}} Category</a>
                                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                        @else
                                            <a href="{{ route('admin.items-category.create',['type'=>$type]) }}" class="btn btn-danger add-btn" ><i class="ri-add-line align-bottom me-1"></i> Create {{$type==2 ? 'Sub':''}} Category</a>
                                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                        @endif
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
                                                <th class="sort" data-sort="tasks_image">Image</th>
                                                <th class="sort" data-sort="tasks_name">Name</th>
                                                @if($type==2)
                                                <th class="sort" data-sort="tasks_category">Category</th>
                                                @endif
                                                <th class="sort" data-sort="assignedto">status</th>
                                                <th class="sort" data-sort="due_date">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($categories as $category)
                                            <tr>
                                                <td class="id">{{ $loop->index + 1 }}</td>
                                                <td class="id">
                                                    @if(!empty($category->image))
                                                        <img id="image-preview" src="{{$type == 1 ? asset('images/supplyCategory/'.$category->image) : asset('images/supplySubCategory/'.$category->image)}}" alt="Image Preview" style="max-width:120px;height:120px;">
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 tasks_name">
                                                            @if($type == 1)
                                                            <a href="{{route('admin.items-category.index',['type'=>2,'category'=>$category->id])}}" class="fw-bold">
                                                            @else
                                                            <a href="{{route('admin.items.index',['category'=>$category->id])}}" class="fw-bold">
                                                            @endif
                                                                <div >{{ $category->name }}</div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                @if($type == 2)
                                                    <td class="tasks_category"><a  class="fw-medium link-primary">{{$category->parentCategory->name}}</a></td>
                                                @endif
                                                <td class="project_name"><a  class="fw-medium link-primary">{{ $category->status }}</a></td>

                                                <td class="assignedto">
                                                    <a href="{{ route('admin.items-category.edit', ['id'=>$category->id,'type'=>$type]) }}" class="btn btn-outline-success">Edit</a>
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" href="#deleteOrder{{$category->id}}">
                                                        Delete
                                                    </button>
                                                </td>

                                            </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                    <!--end table-->
                                    @if($categories->count() == 0)
                                    <div class="noresult">
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
                @foreach ($categories as $category)
                <div class="modal fade flip" id="deleteOrder{{$category->id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4>You are about to delete a category ?</h4>
                                    <p class="text-muted fs-14 mb-4">Deleting your category will remove all of
                                        your information from our database.</p>

                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link btn-ghost-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <form method="POST" action="{{ route('admin.items-category.delete', ['id'=>$category->id,'type'=>$type]) }}" style="display: inline">
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


<!-- End Page-content -->
@endsection

