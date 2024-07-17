@extends('admin.layouts.main')

@php $title =  'Enquiry | Admin Panel'; @endphp

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Follow up of Enquiry : {{ $enquiry->name }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.enquiry.index') }}">Enquiry</a></li>
                                <li class="breadcrumb-item active">Followup Enquiry</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="position-relative mx-n4 mt-n4">
                <div class="profile-wid-bg profile-setting-img">
                    <img src="{{ URL::asset('/assets') }}/images/profile-bg.jpg" class="profile-wid-img" alt="">
                    <div class="overlay-content">

                    </div>
                </div>
            </div>

            <div class="row">

                <!--end col-->
                <div class="col-xxl-12">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link text-body active" data-bs-toggle="tab" href="#personalDetails"
                                        role="tab">
                                        <i class="fas fa-home"></i>
                                        Followup Detail
                                    </a>
                                </li>


                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">


                                    <div class="row">

                                        <!--end col-->

                                        <div class="card-body p-4">
                                            <div class="table-responsive">
                                                <table class="invoice-table table table-borderless table-nowrap mb-0">
                                                    <thead class="align-middle">
                                                        <tr class="table-active">
                                                            <th scope="col" style="width: 50px;">#</th>
                                                            <th scope="col">Follow Up Details</th>
                                                            <th scope="col" style="width: 120px;">Followup Date</th>
                                                            <th scope="col" class="text-end" style="width: 150px;"></th>
                                                            <th scope="col" class="text-end" style="width: 105px;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="followup-details" class="disabled">
                                                        @foreach ($enquiry->followUpDates as $key => $followUpDate)
                                                            <tr class="product">
                                                                <th scope="row" class="product-id">{{ $key + 1 }}
                                                                </th>
                                                                <td class="text-start">
                                                                    <div class="mb-2">
                                                                        <textarea class="form-control bg-light border-0 followup-details" name="followup_remarks[]" rows="2"
                                                                            placeholder="Followup Details" disabled>{{ $followUpDate->remarks }}</textarea>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="date"
                                                                        class="form-control bg-light border-0 followup-date"
                                                                        name="followup_date[]" placeholder="Followup date"
                                                                        value="{{ $followUpDate->follow_up_date }}"
                                                                        disabled />
                                                                </td>
                                                                <td class="product-removal">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>

                                                </table>
                                                <!--end table-->
                                            </div>
                                        </div>



                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <a href="{{ route('admin.enquiry.index') }}" type="button"
                                                    class="btn btn-soft-success">Cancel</a>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    </form>

                                </div>


                                <!--end tab-pane-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>

        </div>
        <!-- container-fluid -->
    </div>
@endsection
