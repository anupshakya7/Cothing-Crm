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
                        <h4 class="mb-sm-0">{{ $vendor->name }} Payment Lists</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.vendors-payment.index')}}">Vendor Payment</a></li>
                                <li class="breadcrumb-item active">{{ $vendor->name }} Payment Lists</li>
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
                                <h5 class="card-title mb-0 flex-grow-1">{{ $vendor->name }} Payment Info</h5>
                                <div class="flex-shrink-0">
                                    {{-- <div class="d-flex flex-wrap gap-2">
                                        <a href="" class="btn btn-danger add-btn"><i
                                                class="ri-add-line align-bottom me-1"></i> Create Vendor Payment</a>
                                        <button class="btn btn-soft-danger" id="remove-actions"
                                            onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                    </div> --}}
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="table-responsive table-card mb-4">
                                {{-- <div class="mb-3 d-flex justify-content-center">
                                    <input type="text" class="form-control w-50 text-center" name="vendor" value="{{ $vendor->name }}"
                                        readonly>
                                </div> --}}

                                <table class="table align-middle table-nowrap mb-0" id="tasksTable">
                                    <thead class="table-light text-muted">
                                        <tr>

                                            <th class="sort" data-sort="project_name">S.N</th>
                                            <th class="sort" data-sort="tasks_name">Total Due</th>
                                            <th class="sort" data-sort="assignedto">Paid Amount</th>
                                            <th class="sort" data-sort="assignedto">New Due</th>
                                            <th class="sort" data-sort="assignedto">Payment Method</th>
                                            <th class="sort" data-sort="assignedto">Payment Date</th>
                                            <th class="sort" data-sort="assignedto">Remarks</th>
                                            <th class="sort" data-sort="due_date">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @php
                                            $previous_paid_amount = 0;
                                        @endphp
                                        @foreach ($payments as $key=>$payment)
                                            @php
                                                $total_due = 0;
                                                $key > 0 ? $total_due = $vendor->SupplyOrders[0]->total_amount - $previous_paid_amount : $total_due = $vendor->SupplyOrders[0]->total_amount;
                                                $new_due = 0;
                                            @endphp
                                            <tr>
                                                <td class="id">{{ $loop->index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1 tasks_name">
                                                            {{$total_due}}
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $payment->total_amount }}</a></td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $total_due - $payment->total_amount }}</a></td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $payment->received_method }}</a>
                                                </td>
                                                <td class="project_name"><a
                                                    class="fw-medium link-primary">{{ $payment->date }}</a>
                                                </td>
                                                <td class="project_name"><a
                                                        class="fw-medium link-primary">{{ $payment->remarks }}</a></td>

                                                <td class="assignedto">
                                                    <a href="{{ route('admin.vendors-payment.edit', $payment->id) }}"
                                                        class="btn btn-outline-success">Edit</a>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-bs-toggle="modal" href="#deletePayment{{ $payment->id }}">
                                                        Delete
                                                    </button>
                                                </td>

                                            </tr>
                                            @php
                                                $previous_paid_amount += $payment->total_amount;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <td></td>
                                        <td>{{$vendor->SupplyOrders[0]->total_amount}}</td>
                                        <td>{{$sumTotal}}</td>
                                        <td>{{$vendor->SupplyOrders[0]->total_amount - $previous_paid_amount}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tfoot>
                                </table>
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


                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
            @foreach ($payments as $payment)
                <div class="modal fade flip" id="deletePayment{{ $payment->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                    colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4>You are about to delete a vendor payment ?</h4>
                                    <p class="text-muted fs-14 mb-4">Deleting your vendor payment will remove all of
                                        your information from our database.</p>

                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link btn-ghost-success fw-medium text-decoration-none"
                                            id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <form method="POST"
                                            action="{{ route('admin.vendors-payment.delete', $payment->id) }}"
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
@endsection
