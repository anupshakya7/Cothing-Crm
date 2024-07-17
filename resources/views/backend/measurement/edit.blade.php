@extends('admin.layouts.main')

@php $title =  'Measurements | Admin Panel'; @endphp

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Measurements</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.items.index') }}">Measurements</a></li>
                            <li class="breadcrumb-item active">Edit Measurement</li>
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

            <!--end col-->
            <div class="col-xxl-12">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-body active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                    <i class="fas fa-home"></i>
                                    Item Measurements
                                </a>
                            </li>


                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form action="{{ route('admin.measurement.update', $measurement->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="categoryInput" class="form-label">Category</label>
                                                <select class="form-control" name="category" data-choices data-choices-search-false>
                                                    <option value="">Select Category</option>
                                                    <option value="Baby" @if($measurement->category == "Baby") selected @endif>Babies</option>
                                                    <option value="Boy" @if($measurement->category == "Boy") selected @endif>Boy</option>
                                                    <option value="Girl" @if($measurement->category == "Girl") selected @endif>Girl</option>
                                                    <option value="Men's" @if($measurement->category == "Men's") selected @endif>Men's</option>
                                                    <option value="Women's" @if($measurement->category == "Women's") selected @endif>Women's</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{$errors->first('category') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="sizeInput" class="form-label">Size</label>
                                                <input type="text" class="form-control" name="size" id="sizeInput" placeholder="Size" value="{{ $measurement->size }}">
                                                <div class="invalid-feedback">
                                                    {{$errors->first('size') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">Top</label>

                                                <textarea name="top" id="ckeditor-classic">{{ old('top',$measurement->top) }}</textarea>

                                                <div class="invalid-feedback">
                                                    {{ $errors->first('top') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">Bottom</label>
                                                <textarea name="bottom" id="ckeditor-classic1">{{ old('bottom',$measurement->bottom) }}</textarea>

                                                <div class="invalid-feedback">
                                                    {{ $errors->first('bottom') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="remarksInput" class="form-label">Remarks</label>
                                                <textarea class="form-control" name="remarks" id="remarksInput">{{ $measurement->description }}</textarea>
                                                <div class="invalid-feedback">
                                                    {{$errors->first('remarks') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="statusInput" class="form-label">Status</label>
                                                <select class="form-control" name="status" data-choices data-choices-search-false>
                                                    <option value="Active" @if($measurement->status == 'Active') selected @endif>Active</option>
                                                    <option value="Inactive" @if($measurement->status == 'Inactive') selected @endif>Inactive</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{$errors->first('status') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                        <!--end col-->


                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary">Updates</button>
                                                <a href="{{ route('admin.measurement.index') }}" type="button" class="btn btn-soft-success">Cancel</a>
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
@endsection

@push('default-scripts')


<script src="{{ URL::asset('/assets') }}/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

    <script>
        var ckeditorClassic = document.querySelector('#ckeditor-classic');
        if (ckeditorClassic) {
            ClassicEditor
                .create(document.querySelector('#ckeditor-classic'))
                .then(function(editor) {
                    editor.ui.view.editable.element.style.height = '200px';
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
    </script>
    <script>
        var ckeditorClassic1 = document.querySelector('#ckeditor-classic1');
        if (ckeditorClassic1) {
            ClassicEditor
                .create(document.querySelector('#ckeditor-classic1'))
                .then(function(editor) {
                    editor.ui.view.editable.element.style.height = '200px';
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
    </script>


@endpush
