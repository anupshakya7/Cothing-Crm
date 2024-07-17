@extends('admin.layouts.main')

@php $title =  'Vendor Payment Lists | Admin Panel'; @endphp

@section('content')


    <!-- ============================================================== -->

        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Vendor Payment Lists</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Vendors Payment</a></li>
                                    <li class="breadcrumb-item active">Vendor Payment Lists</li>
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
                                    <h5 class="card-title mb-0 flex-grow-1">All Vendor Payment Info</h5>
                                    <div class="flex-shrink-0">
                                       <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ route('admin.vendors-payment.create') }}" class="btn btn-danger add-btn" ><i class="ri-add-line align-bottom me-1"></i> Create Vendor Payment</a>
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
                                                <th class="sort" data-sort="vendor_name">Vendor</th>
                                                <th class="sort" data-sort="tasks_name">Total Amount</th>
                                                <th class="sort" data-sort="assignedto">Date</th>
                                                <th class="sort" data-sort="assignedto">Received By</th>
                                                <th class="sort" data-sort="assignedto">Received Method</th>
                                                <th class="sort" data-sort="assignedto">Remarks</th>
                                                <th class="sort" data-sort="due_date">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($payments as $payment)
                                            <tr>
                                                <td class="id">{{ $loop->index + 1 }}</td>
                                                <td class="vendor_name"><a class="fw-medium link-primary">{{ $payment->Vendor->name }}</a></td>
                                                @if(count($payment->VendorPayment) == 0)
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1 tasks_name">
                                                                {{ $payment->total_amount }}
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="project_name"><a class="fw-medium link-primary">{{ $payment->latest_date }}</a></td>
                                                    <td class="project_name"><a class="fw-medium link-primary"></a></td>
                                                    <td class="project_name"><a class="fw-medium link-primary"></a></td>
                                                    <td class="project_name"><a class="fw-medium link-primary"></a></td>
                                                @else
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1 tasks_name">
                                                                {{ $payment->VendorPayment[0]->total_amount }}
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="project_name"><a class="fw-medium link-primary">{{ $payment->VendorPayment[0]->date }}</a></td>
                                                    <td class="project_name"><a class="fw-medium link-primary">{{ $payment->VendorPayment[0]->received_by }}</a></td>
                                                    <td class="project_name"><a class="fw-medium link-primary">{{ $payment->VendorPayment[0]->received_method }}</a></td>
                                                    <td class="project_name"><a class="fw-medium link-primary">{{ $payment->VendorPayment[0]->remarks }}</a></td>
                                                @endif
                                                

                                                <td class="assignedto">
                                                    <a href="{{ route('admin.vendors-payment.detail', $payment->vendor_id) }}" class="btn btn-outline-success">Details</a>
                                                    @if(count($payment->VendorPayment) != 0)
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" href="#deletePayment{{$payment->vendor_id}}">
                                                        Delete
                                                    </button>
                                                    @endif
                                                </td>
                                               
                                              

                                            </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                    <!--end table-->
                                    <div class="noresult" style="display: none">
                                        <div class="text-center">
                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
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
                @foreach ($payments as $payment)
                <div class="modal fade flip" id="deletePayment{{$payment->vendor_id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4>You are about to delete a vendor payment ?</h4>
                                    <p class="text-muted fs-14 mb-4">Deleting your vendor payment will remove all of
                                        your information from our database.</p>

                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link btn-ghost-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <form method="POST" action="{{route('admin.vendors-payment.delete.all',$payment->vendor_id)}}" style="display: inline">
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

