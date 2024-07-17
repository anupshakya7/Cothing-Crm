@extends('admin.layouts.main')

@php $title =  'Products | Admin Panel'; @endphp

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Products</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Products</a></li>
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
                                    Products Detail
                                </a>
                            </li>


                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form id="editForm" action="{{ route('admin.product.update', $product->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="project-thumbnail-img" class="form-label">Product Image</label>
                                                <input class="form-control" id="project-thumbnail-img" type="file" name="image" accept="image/png, image/gif, image/jpeg" onchange="previewImage(event)">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('image') }}
                                                </div>
                                            </div>

                                            <div id="image-preview-container" class="col-lg-6 mb-2">
                                            @if($product->image)
                                            <img id="image-preview" src="{{ asset('images/product/' . $product->image) }}" alt="Image Preview" style="max-width: 100%; height: 150px;">
                                            @else
                                            <img id="image-preview" src="#" alt="Image Preview" style="display: none; max-width: 100%; height: 150px;">
                                            @endif
                                        </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="product-name-input" class="form-label">Product Name</label>
                                                <input type="text" class="form-control" id="product-name-input" name="name" placeholder="Enter Product Name" value="{{ $product->name }}">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="product-category-input" class="form-label">Category</label>
                                                <select class="form-select" name="category">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categorys as $category)
                                                        @php
                                                            $subcategorys = $category->getSubCategories($category->id);
                                                        @endphp
                                                        @if (count($subcategorys) > 0)
                                                            <optgroup label="{{ $category->name }}" class="main_category">

                                                                @foreach ($subcategorys as $subcategory)
                                                                    @php
                                                                        $tcategorys = $subcategory->getSubCategories(
                                                                            $subcategory->id,
                                                                        );
                                                                    @endphp
                                                                    @if (count($tcategorys) > 0)
                                                            <optgroup label="{{ $subcategory->name }}" class="sub_category">

                                                                @foreach ($tcategorys as $data)
                                                                    <option value="{{ $data->id }}" {{ $data->id == $product->category_id ? 'selected' : '' }} class="category">{{ $data->name }}
                                                                    </option>
                                                                @endforeach
                                                            </optgroup>
                                                        @else
                                                            <option value="{{ $subcategory->id }}" {{ $subcategory->id == $product->category_id ? 'selected' : '' }} class="sub_category">
                                                                {{ $subcategory->name }}</option>
                                                        @endif
                                                    @endforeach
                                                    </optgroup>
                                                @else
                                                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }} class="main_category">{{ $category->name }}
                                                    </option>
                                                    @endif
                                                    @endforeach



                                                </select>


                                                <div class="invalid-feedback">
                                                    {{ $errors->first('category') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="skillsInput" class="form-label">Pattern</label>
                                                <select class="form-select" name="pattern" data-choices
                                                    data-choices-search-false name="choices-single-default2">
                                                    <option value="">Select pattern</option>
                                                   @foreach ($patterns as $pattern)
                                                   <option value="{{ $pattern->id }}"
                                                    {{ $pattern->id == old('pattern',$product->pattern_id) ? 'selected' : '' }}>
                                                    {{ $pattern->name }} ({{ $pattern->sizecategory }})
                                                    @if (isset($pattern->measurement->size))
                                                        ({{ $pattern->measurement->size }})
                                                    @endif
                                                </option>

                                                   @endforeach

                                                </select>

                                                <div class="invalid-feedback">
                                                    {{ $errors->first('pattern') }}
                                                </div>


                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="skillsInput" class="form-label">Measurement</label>
                                                <select class="form-select" name="measurement" data-choices
                                                    data-choices-search-false name="choices-single-default2">
                                                    <option value="">Select Measurement</option>
                                                    @foreach ($measurements as $measurement)
                                                   <option value="{{ $measurement->id }}" {{ $measurement->id == $product->measurement_id ? 'selected' : '' }}>{{ $measurement->size }}</option>

                                                   @endforeach

                                                </select>

                                                <div class="invalid-feedback">
                                                    {{ $errors->first('measurement') }}
                                                </div>


                                            </div>
                                        </div> --}}

                                        <div class="col-lg-6 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="product-price-input">Price</label>
                                                <div class="input-group has-validation mb-3">
                                                    <span class="input-group-text"
                                                        id="product-price-addon">Rs</span>
                                                    <input type="number" class="form-control"
                                                        id="product-price-input" placeholder="Enter price"
                                                        name="price" step="0.01"
                                                        value="{{ old('price',$product->price) }}" required>
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('price') }}</div>

                                                </div>

                                            </div>
                                        </div>

                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="skillsInput" class="form-label">Status</label>
                                                <select class="form-select" name="status" data-choices
                                                    data-choices-search-false name="choices-single-default2">
                                                    <option value="Active" {{ $product->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                    <option value="Inactive" {{ $product->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>

                                                </select>

                                                <div class="invalid-feedback">
                                                    {{ $errors->first('status') }}
                                                </div>


                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">Remarks</label>
                                               <textarea class="form-control" name="remarks">{{ old('remaks',$product->description) }}</textarea>
                                                <div class="invalid-feedback">
                                                    {{$errors->first('remarks') }}
                                                    </div>
                                            </div>
                                        </div>



                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <a href="{{ route('admin.product.index') }}" class="btn btn-soft-success">Cancel</a>
                                            </div>
                                        </div>
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
<script>
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function(){
            var imagePreview = document.getElementById('image-preview');
            imagePreview.src = reader.result;
            imagePreview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
</script>
@push('default-scripts')

        <!-- ckeditor -->
 <script src="{{URL::asset('/assets')}}/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

 <!-- dropzone js -->
 <script src="{{URL::asset('/assets')}}/libs/dropzone/dropzone-min.js"></script>
 <!-- project-create init -->
 <script src="{{URL::asset('/assets')}}/js/pages/project-create.init.js"></script>
 <script>
var previewTemplate1,dropzone1,dropzonePreviewNode1=(document.querySelector("#dropzone-preview-list1"));dropzonePreviewNode1&&(dropzonePreviewNode1.id="",previewTemplate1=dropzonePreviewNode1.parentNode.innerHTML,dropzonePreviewNode1.parentNode.removeChild(dropzonePreviewNode1),dropzone1=new Dropzone(".dropzone1",{url:"https://httpbin.org/post",method:"post",previewTemplate:previewTemplate1,previewsContainer:"#dropzone-preview1"}));

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

<style>
    .main_category{
        color: green !important;
        font-weight: 700 !important;
    }
    .sub_category{
        color: Blue !important;
        font-weight: 500 !important;
        margin-left: 5px !important;
        padding: 0px 4px 2px !important;
        margin-left: 20px !important; /* Adjust this value according to your preference */


    }
    .category{
        color: black !important;
        padding: 0px 2px 1px !important;
    }
</style>


@endpush
