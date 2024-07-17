@extends('admin.layouts.main')

@php $title =  'Pattern | Admin Panel'; @endphp

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Pattern</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.pattern.index') }}">Pattern</a></li>
                                <li class="breadcrumb-item active">Edit Pattern</li>
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
                                        Pattern Details
                                    </a>
                                </li>


                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                    <form action="{{ route('admin.pattern.update', $pattern->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="patternImage" class="form-label">Pattern Image</label>
                                                    <input class="form-control" id="patternImage" type="file"
                                                        name="image" accept="image/png, image/gif, image/jpeg"
                                                        onchange="previewImage(event)">
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('image') }}
                                                    </div>
                                                </div>

                                                <div id="image-preview-container" class="col-lg-6 mb-2">
                                                    @if ($pattern->image)
                                                        <img id="image-preview"
                                                            src="{{ asset('images/pattern/' . $pattern->image) }}"
                                                            alt="Image Preview" style="max-width: 100%; height: 150px;">
                                                    @else
                                                        <img id="image-preview" src="#" alt="Image Preview"
                                                            style="display: none; max-width: 100%; height: 150px;">
                                                    @endif
                                                </div>

                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="patternName" class="form-label">Pattern Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                        id="patternName" placeholder="Enter Pattern Name"
                                                        value="{{ $pattern->name }}">
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('name') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="firstnameInput" class="form-label">Size category</label>
                                                    <select class="form-control" name="category" data-choices
                                                        data-choices-search-false name="choices-single-default2">
                                                        <option value="">Select Size category</option>
                                                        <option value="Baby"
                                                            @if (old('category', $pattern->sizecategory) == 'Baby') selected @endif>Babies
                                                        </option>
                                                        <option value="Boy"
                                                            @if (old('category', $pattern->sizecategory) == 'Boy') selected @endif>Boy</option>
                                                        <option value="Girl"
                                                            @if (old('category', $pattern->sizecategory) == 'Girl') selected @endif>Girl</option>
                                                        <option value="Men's"
                                                            @if (old('category', $pattern->sizecategory) == "Men's") selected @endif>Men's</option>
                                                        <option value="Women's"
                                                            @if (old('category', $pattern->sizecategory) == "Women's") selected @endif>Women's
                                                        </option>

                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('category') }}
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="patternSize" class="form-label">Size (m)</label>
                                                    <select class="form-select" name="size">
                                                        <option value="">Select Size</option>
                                                        @foreach ($sizes as $size)
                                                            <option value="{{ $size->id }}"
                                                                @if (old('size', $pattern->size) == $size->id) selected @endif>
                                                                {{ $size->size }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('size') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="patternStatus" class="form-label">Status</label>
                                                    <select class="form-select" name="status" data-choices
                                                        data-choices-search-false>
                                                        <option value="Active"
                                                            {{ $pattern->status == 'Active' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="Inactive"
                                                            {{ $pattern->status == 'Inactive' ? 'selected' : '' }}>Inactive
                                                        </option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('status') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <a href="{{ route('admin.pattern.index') }}" type="button"
                                                        class="btn btn-soft-success">Cancel</a>
                                                </div>
                                            </div>
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
            $('select[name="category"]').change(function() {
                var category = $(this).val();
                if (category) {
                    $.ajax({
                        url: '/admin/pattern/sizes/' + category,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="size"]').empty();
                            $('select[name="size"]').append(
                                '<option value="">Select Size</option>');
                            $.each(data, function(key, value) {
                                $('select[name="size"]').append('<option value="' +
                                    value.id + '">' + value.size + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="size"]').empty();
                }
            });
        });
    </script>
@endsection
<script>
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function() {
            var imagePreview = document.getElementById('image-preview');
            imagePreview.src = reader.result;
            imagePreview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
</script>
@push('default-scripts')
    <!-- ckeditor -->
    <script src="{{ URL::asset('/assets') }}/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

    <!-- dropzone js -->
    <script src="{{ URL::asset('/assets') }}/libs/dropzone/dropzone-min.js"></script>
    <!-- project-create init -->
    <script src="{{ URL::asset('/assets') }}/js/pages/project-create.init.js"></script>
    <script>
        var previewTemplate1, dropzone1, dropzonePreviewNode1 = (document.querySelector("#dropzone-preview-list1"));
        dropzonePreviewNode1 && (dropzonePreviewNode1.id = "", previewTemplate1 = dropzonePreviewNode1.parentNode.innerHTML,
            dropzonePreviewNode1.parentNode.removeChild(dropzonePreviewNode1), dropzone1 = new Dropzone(".dropzone1", {
                url: "https://httpbin.org/post",
                method: "post",
                previewTemplate: previewTemplate1,
                previewsContainer: "#dropzone-preview1"
            }));
    </script>

    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            $('#output').show();

            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory

            }
        };

        document.getElementById('group-image').addEventListener('change', function() {
            document.getElementById('imagehide').style.display = 'none';
        });
    </script>
@endpush
