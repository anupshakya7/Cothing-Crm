@extends('admin.layouts.main')

@php $title =  'Category | Admin Panel'; @endphp

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">EditSub Category</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.category.index', ['type' => $type]) }}">Category</a></li>
                                <li class="breadcrumb-item active">Sub Category</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="position-relative mx-n4 mt-n4">
                <div class="profile-wid-bg profile-setting-img">
                    <img src="{{ URL::asset('/assets') }}/images/profile-bg.jpg" class="profile-wid-img" alt="">
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

                <!--end col-->
                <div class="col-xxl-12">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link text-body active" data-bs-toggle="tab" href="#personalDetails"
                                        role="tab">
                                        <i class="fas fa-home"></i>
                                        Sub Category Details
                                    </a>
                                </li>


                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                    <form action="{{ route('admin.category.update', $category->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="category_type" value="{{ $type }}" />

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="firstnameInput" class="form-label">Main Category
                                                        Name</label>
                                                    <select class="form-select select2" name="maincategory">
                                                        <option value="">Select Main category</option>
                                                        @foreach ($maincategorys as $main)
                                                            <option value="{{ $main->id }}"
                                                                {{ $main->id == old('maincategory',isset($main_cat->parent_category) ? $main_cat->parent_category : null) ? 'selected' : '' }}>
                                                                {{ $main->name }}</option>
                                                        @endforeach

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('maincategory') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="firstnameInput" class="form-label"> Category
                                                        Name</label>
                                                    <select class="form-select select2" name="category" >
                                                        <option value="">Select  category</option>
                                                        @foreach ($categorys as $categoryss)
                                                            <option value="{{ $categoryss->id }}"
                                                                {{ $categoryss->id == $category->parent_category ? 'selected' : '' }}>
                                                                {{ $categoryss->name }}</option>
                                                        @endforeach

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('category') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="firstnameInput" class="form-label">Sub Category
                                                        Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                        id="firstnameInput" placeholder="Enter your Full Name"
                                                        value="{{ $category->name }}">
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('name') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="skillsInput" class="form-label">Status</label>
                                                    <select class="form-control" name="status" data-choices
                                                        data-choices-search-false name="choices-single-default2">
                                                        <option value="Active"
                                                            {{ $category->status == 'Active' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="Inactive"
                                                            {{ $category->status == 'Inactive' ? 'selected' : '' }}>
                                                            Inactive</option>

                                                    </select>

                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('status') }}
                                                    </div>


                                                </div>
                                            </div>

                                            <!--end col-->


                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Updates</button>
                                                    <a href="{{ route('admin.category.index', ['type' => $type]) }}"
                                                        type="button" class="btn btn-soft-success">Cancel</a>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('select[name="maincategory"]').change(function() {
                var category = $(this).val();
                if (category) {
                    $.ajax({
                        url: '/admin/category/maincategory/' + category,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="category"]').empty();
                            $('select[name="category"]').append(
                                '<option value="">Select Sub Category</option>');
                            $.each(data, function(key, value) {
                                $('select[name="category"]').append('<option value="' +
                                    value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="category"]').empty();
                }
            });
        });
    </script>@endsection
