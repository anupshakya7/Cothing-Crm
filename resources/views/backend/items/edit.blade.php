@extends('admin.layouts.main')

@php $title =  'itemsupplyorder | Admin Panel'; @endphp

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Item</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.items.index') }}">Item</a></li>
                            <li class="breadcrumb-item active">Edit Item</li>
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
                                    Item Details
                                </a>
                            </li>


                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                      <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="project-thumbnail-img" class="form-label">Item Image</label>
                                                <input class="form-control" id="project-thumbnail-img" type="file" name="image" accept="image/png, image/gif, image/jpeg" onchange="previewImage(event)">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('image') }}
                                                </div>
                                            </div>

                                            <div id="image-preview-container" class="col-lg-6 mb-2">
                                                @if(!empty($item->image))
                                                <img id="image-preview" src="{{ asset('images/supplyItem/' . $item->image) }}" alt="Image Preview" style="max-width: 100%; height: 150px;">
                                                @else
                                                <img id="image-preview" src="#" alt="Image Preview" style="display: none; max-width: 100%; height: 150px;">
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">Item
                                                    Name</label>
                                                <input type="text" class="form-control" name="name" id="firstnameInput" placeholder="Enter your Full Name" value="{{ $item->name }}">
                                                <div class="invalid-feedback">
                                                    {{$errors->first('name') }}
                                                    </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="categoryInput" class="form-label">Category
                                                    </label>
                                                    <select class="form-select select2" name="category" >
                                                    <option value="">Select category</option>
                                                   @foreach ($categories as $category)
                                                   <option value="{{ $category->id }}" @if(!empty($item->category)){{ $category->id == old('category',$item->category->id) ? 'selected' : '' }} @endif>{{ $category->name }}</option>
                                                   @endforeach

                                                </select>
                                                <div class="invalid-feedback">
                                                    {{$errors->first('category') }}
                                                    </div>
                                            </div>
                                        </div>

                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="skillsInput" class="form-label">Status</label>
                                                <select class="form-control" name="status" data-choices data-choices-search-false name="choices-single-default2">
                                                    <option value="Active" {{ $item->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                    <option value="Inactive" {{ $item->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>

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
                                                <button type="submit" class="btn btn-primary">Updates</button>
                                                <a href="{{ route('admin.items.index') }}" type="button" class="btn btn-soft-success">Cancel</a>
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


@endpush

@section('scripts')
<script>
    function previewImage(event){
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function(){
            var imagePreview = document.getElementById('image-preview');
            imagePreview.src = reader.result;
            imagePreview.style.display = 'block'; 
        }

        reader.readAsDataURL(input.files[0]);
    }
</script>
@endsection
