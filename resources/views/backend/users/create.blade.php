@extends('admin.layouts.main')

@php $title =  'User Create | Admin Panel'; @endphp

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Create User</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                            <li class="breadcrumb-item active">Create users</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg profile-setting-img">
                <img src="{{URL::asset('/assets')}}/images/profile-bg.jpg" class="profile-wid-img" alt="">
                <div class="overlay-content">
                    {{-- <div class="text-end p-3">
                        <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                            <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                            <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                                <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                            </label>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="row">

                <!--end card-->

                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-xxl-12">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-body active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                    <i class="fas fa-home"></i>
                                    Personal Details
                                </a>
                            </li>

                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" autocomplete="false">
                                    @csrf
                                    @method('POST')
                                      <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">Profile</label>
                                                    <input type="file" class="form-control" name="image" id="image" >
                                                    <div class="invalid-feedback">
                                                    {{$errors->first('image') }}
                                                    </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">Full
                                                    Name</label>
                                                <input type="text" class="form-control" name="name" id="firstnameInput" placeholder="Enter your Full Name" value="{{old('name')}}">
                                                <div class="invalid-feedback">
                                                    {{$errors->first('name') }}
                                                    </div>
                                            </div>
                                        </div>

                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="phonenumberInput" class="form-label">Phone
                                                    Number</label>
                                                <input type="text" class="form-control" name="phone_no" id="phonenumberInput" placeholder="Enter your phone number"  value="{{old('phone_no')}}">
                                                <div class="invalid-feedback">
                                                    {{$errors->first('phone_no') }}
                                                    </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="emailInput" class="form-label">Email
                                                    Address</label>
                                                <input type="email" class="form-control" name="email" id="emailInput" placeholder="Enter your email"  value="{{old('email')}}">
                                                <div class="invalid-feedback">
                                                    {{$errors->first('email') }}
                                                    </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="emailInput" class="form-label">Password</label>
                                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="false">
                                                    <div class="invalid-feedback">
                                                    {{$errors->first('password') }}
                                                    </div>
                                            </div>
                                        </div>


                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="skillsInput" class="form-label">Status</label>
                                                <select class="form-control" name="status" data-choices data-choices-search-false name="choices-single-default2">
                                                    <option value="Active" >Active</option>
                                                    <option value="Inactive" >Inactive</option>

                                                </select>

                                                <div class="invalid-feedback">
                                                    {{$errors->first('status') }}
                                                    </div>


                                            </div>
                                        </div>

                                        <!--end col-->


                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary">Create</button>
                                                <button type="button" class="btn btn-soft-success">Cancel</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                            <!--end tab-pane-->


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

