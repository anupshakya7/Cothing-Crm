@extends('admin.layouts.main')

@php $title =  'Supplier Orders Edit | Admin Panel'; @endphp

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Supplier Orders Edit</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.index') }}">Supplier Orders</a>
                                </li>
                                <li class="breadcrumb-item active">Edit Supplier Orders</li>
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

                <!--end card-->

                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-xxl-12">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-body active" data-bs-toggle="tab" href="#personalDetails"
                                    role="tab">
                                    <i class="fas fa-home"></i>
                                    Supplier Orders Details
                                </a>
                            </li>

                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST"
                                    enctype="multipart/form-data" autocomplete="false">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-lg-9">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label"
                                                                for="product-title-input">Vendor</label>
                                                            <select
                                                                class="form-select {{ $errors->has('vendor') ? 'is-invalid' : '' }} select2"
                                                                id="choices-category-input" name="vendor" required>
                                                                <option value="">select vendor</option>
                                                                @foreach ($vendors as $vendor)
                                                                    <option value="{{ $vendor->id }}"
                                                                        {{ $vendor->id == $supplier->vendor_id ? 'selected' : '' }}>
                                                                        {{ $vendor->name }}
                                                                    </option>
                                                                @endforeach

                                                            </select>

                                                            <div class="invalid-feedback">{{ $errors->first('vendor') }}
                                                            </div>
                                                        </div>


                                                        <div class="table-responsive">
                                                            <table
                                                                class="invoice-table table table-borderless table-nowrap mb-0">
                                                                <thead class="align-middle">
                                                                    <tr class="table-active">
                                                                        <th scope="col" style="width: 50px;">#</th>
                                                                        <th scope="col">Category</th>
                                                                        <th scope="col">Sub Category</th>
                                                                        <th scope="col">Items</th>
                                                                        <th scope="col">Rate</th>
                                                                        <th scope="col">Quantity</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="followup-details">
                                                                    @php($i = 0);
                                                                    @foreach($supplierItems as $supplierItem)
                                                                    @php($i++);
                                                                    <tr class="product">
                                                                        <th scope="row" class="product-id">{{$i}}</th>
                                                                        <td class="text-start">
                                                                            <div class="mb-2">
                                                                                <select
                                                                                class="form-select {{ $errors->has('category') ? 'is-invalid' : '' }} select2"
                                                                                id="choices-categorys-input-{{$i}}" name="category[]" required>
                                                                                <option value="">Select Category</option>
                                                                                @foreach ($categories as $category)
                                                                                    <option value="{{ $category->id }}"
                                                                                        {{ $category->id == $supplierItem->category_id ? 'selected' : '' }}>
                                                                                        {{ $category->name }}
                                                                                    </option>
                                                                                @endforeach
                
                                                                            </select>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-start">
                                                                            <div class="mb-2">
                                                                                <select
                                                                                class="form-select {{ $errors->has('subcategory') ? 'is-invalid' : '' }} select2"
                                                                                id="choices-sub-categorys-input" name="subcategory[]" required>
                                                                                <option value="">Select Sub Category</option>
                                                                                @foreach ($subcategories as $category)
                                                                                    <option value="{{ $category->id }}"
                                                                                        {{ $category->id == $supplierItem->subcategory_id ? 'selected' : ''  }}>
                                                                                        {{ $category->name }}
                                                                                    </option>
                                                                                @endforeach
                
                                                                            </select>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="mb-2">
                                                                                <select
                                                                                class="form-select {{ $errors->has('item') ? 'is-invalid' : '' }} select2"
                                                                                id="choices-items-input-{{$i}}" name="item[]" required>
                                                                                <option value="">Select Item</option>
                                                                                @foreach ($items as $item)
                                                                                    <option value="{{ $item->id }}"
                                                                                        {{ $item->id == $supplierItem->item_id ? 'selected' : '' }}>
                                                                                        {{ $item->name }}
                                                                                    </option>
                                                                                @endforeach
                
                                                                            </select>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                            id="product-price-input" placeholder="Enter price"
                                                                            name="price[]" step="0.01"
                                                                            value="{{ $supplierItem->price }}" style="width:70px;" required>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                            id="orders-input" placeholder="Orders" step="0.01"
                                                                            name="quantity[]" value="{{ $supplierItem->qty }}"
                                                                            required>
                                                                        </td>
                                                                        <td class="product-removal">
                                                                            <a href="javascript:void(0)"
                                                                                class="btn btn-success btn-delete">Delete</a>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <button type="button" id="add-item"
                                                                                class="btn btn-soft-secondary fw-medium"><i
                                                                                    class="ri-add-fill me-1 align-bottom"></i>
                                                                                Add
                                                                                Item</button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3"></td>
                                                                        <td colspan="2">Subtotal</td>
                                                                        <td id="subtotal">0.00</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="3"></td>
                                                                        <td colspan="2">Discount</td>
                                                                        <td id="discount_amount">
                                                                            <input type="number" class="form-control" step="0.01" placeholder="discount" name="discount_amount" value="{{$supplier->discount}}">
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="3"></td>
                                                                        <td colspan="3">
                                                                            <hr>
                                                                        </td>
                                                                    </tr>

                                                                    {{-- <tr>
                                                                        <td colspan="3"></td>
                                                                        <td colspan="2">Taxable Amount:</td>
                                                                        <td id="taxable_amount">
                                                                            0.00
                                                                        </td>
                                                                    </tr> --}}

                                                                    {{-- <tr>
                                                                        <td colspan="3"></td>
                                                                        <td colspan="2">VAT (13%):</td>
                                                                        <td id="vat">0.00</td>
                                                                    </tr> --}}

                                                                    <tr>
                                                                        <td colspan="3"></td>
                                                                        <td colspan="2">Grand Total:</td>
                                                                        <td id="grand-total">0.00</td>
                                                                        <input type="hidden" name="total_amount" value="{{old('total_amount')}}">
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                            <!--end table-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end p-3">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <a href="{{ route('admin.suppliers.detail',['vendor'=>$supplier->vendor_id,'date_type'=>'Custom']) }}" type="button"
                                                            class="btn btn-soft-success">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card -->



                                            <!-- end card -->

                                        </div>
                                        <div class="col-lg-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label"
                                                                for="product-title-input">Remarks</label>
                                                                <textarea class="form-control" placeholder="Enter the remarks" name="remarks" rows="3">{{ old('remarks',$supplier->remarks) }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label"
                                                                for="product-title-input">Order Date</label>
                                                                <input type="text" id="nepali-date-picker"
                                                                            name="date" class="form-control"
                                                                            value="{{ old('date',$supplier->date) }}" placeholder="Enter publish date"
                                                                          >
                                                                <div class="invalid-feedback">{{ $errors->first('date') }}
                                                                </div>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <input type="hidden" value="0" name="hasVAT">
                                                            <input class="form-check-input" type="checkbox" value="1" {{$supplier->hasVat == 1 ? 'checked':''}} name="hasVAT" id="hasVAT">
                                                            <label class="form-check-label" for="hasVAT">
                                                              Has VAT Bill
                                                            </label>
                                                            <div class="invalid-feedback">{{ $errors->first('hasVAT') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->

                                    </div>
                                    <!-- end row -->

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
@section('scripts')
<script class="text/javascript">
    window.onload = function(){
        var orderData = document.getElementById('nepali-date-picker');
        orderData.nepaliDatePicker();
    }
</script>
<script>
    function addNewItem() {
        var $categories = <?php echo json_encode($categories); ?>;
        var $subcategories = <?php echo json_encode($subcategories); ?>;
        var $items = <?php echo json_encode($items) ?>;

        var table = document.getElementById('followup-details');
        var newRow = table.insertRow();
        newRow.className = 'product';

        var cellId = newRow.insertCell(0);
        cellId.className = 'product-id';
        cellId.textContent = table.rows.length;

        //Category Clone Field
        var cellCategory = newRow.insertCell(1);
        var categorySelect = document.createElement('select');
        categorySelect.className = 'form-select select2';
        categorySelect.setAttribute('name','category[]');
        categorySelect.setAttribute('required','true'); //Add required attribute
        var categoryOption = document.createElement('option');
        categoryOption.value='';
        categoryOption.textContent = 'Select Category';
        categorySelect.appendChild(categoryOption);

        $categories.forEach(function(category){
            var option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.name;
            categorySelect.appendChild(option);
        });
        cellCategory.appendChild(categorySelect);

        //SubCategory Clone Field
        var cellSubCategory = newRow.insertCell(2);
        var subcategorySelect = document.createElement('select');
        subcategorySelect.className = 'form-select select2';
        subcategorySelect.setAttribute('name','subcategory[]');
        subcategorySelect.setAttribute('required','true'); //Add required attribute
        var subcategoryOption = document.createElement('option');
        subcategoryOption.value='';
        subcategoryOption.textContent = 'Select Category';
        subcategorySelect.appendChild(subcategoryOption);

        $subcategories.forEach(function(subcategory){
            var option = document.createElement('option');
            option.value = subcategory.id;
            option.textContent = subcategory.name;
            subcategorySelect.appendChild(option);
        });
        cellSubCategory.appendChild(subcategorySelect);

        //Items Clone Field
        var cellItem = newRow.insertCell(3);
        var itemSelect = document.createElement('select');
        itemSelect.className = 'form-select select2';
        itemSelect.setAttribute('name','item[]');
        itemSelect.setAttribute('required','true'); //Add required attribute
        var itemOption = document.createElement('option');
        itemOption.value='';
        itemOption.textContent = 'Select Item';
        itemSelect.appendChild(itemOption);

        $items.forEach(function(item){
            var option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.name;
            itemSelect.appendChild(option);
        });
        cellItem.appendChild(itemSelect);

        //Price Clone Field
        var cellPrice = newRow.insertCell(4);
        var priceInput = document.createElement('input');
        priceInput.type = 'number';
        priceInput.className = 'form-control';
        priceInput.id = 'product-price-input';
        priceInput.placeholder = 'Enter price';
        priceInput.step = '0.01';
        priceInput.name = 'price[]';
        priceInput.style.width="70px";
        priceInput.required = true;
        priceInput.value = '';
        cellPrice.appendChild(priceInput);

        //Quantity Clone Field
        var cellQuantity = newRow.insertCell(5);
        var quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.className = 'form-control';
        quantityInput.id = 'orders-input';
        quantityInput.placeholder = 'Orders';
        quantityInput.step = '0.01';
        quantityInput.name = 'quantity[]';
        quantityInput.required = true;
        quantityInput.value = '';
        cellQuantity.appendChild(quantityInput);

        var cellRemoval = newRow.insertCell(6);
        var deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.className = 'btn btn-success btn-delete';
        deleteButton.textContent = 'Delete';
        deleteButton.addEventListener('click', function() {
            deleteRow(newRow);
        });
        cellRemoval.appendChild(deleteButton);

        $('.select2').select2();
    }

    function deleteRow(row) {
        var table = document.getElementById('followup-details');
        row.parentNode.removeChild(row);
        calculateTotal();
        updateIds();
    }

    function updateIds() {
        var table = document.getElementById('followup-details');
        var rows = table.getElementsByClassName('product');
        for (var i = 0; i < rows.length; i++) {
            rows[i].getElementsByClassName('product-id')[0].textContent = i + 1;
        }
    }

    document.getElementById('add-item').addEventListener('click', function() {
        addNewItem();
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Add delete functionality to existing delete buttons
        var deleteButtons = document.getElementsByClassName('btn-delete');
        for (var i = 0; i < deleteButtons.length; i++) {
            deleteButtons[i].addEventListener('click', function() {
                deleteRow(this.parentNode.parentNode);
            });
        }
    });


    function calculateTotal(){
        var total = 0;
        $('tr.product').each(function(){
            var quantity = $(this).find('input[name="quantity[]"]').val();
            var price = $(this).find('input[name="price[]"]').val();
            if(quantity && price){
                total += quantity * price;
            }
            var discount = $('input[name="discount_amount"]').val();
            var grandtotal = discount ? total - discount : total;
            $('#subtotal').text(total);
            $('#grand-total').text(grandtotal);
            $('[name="total_amount"]').val(grandtotal);
        });
    }
</script>
<script>
$(document).ready(function(){
    calculateTotal();
    $(document).on('change','#product-price-input,#orders-input,input[name="discount_amount"]',function(){
        calculateTotal();
    });

     //Data According to Category
     $(document).on('change','select[name="category[]"]',function(){
            var category = $(this).val();
            var $row = $(this).closest('.product');

            if(category){
                $.ajax({
                    url:'/admin/suppliers/category-subcategory/'+category,
                    type:'GET',
                    dataType:'json',
                    success:function(data){
                        $row.find('select[name="subcategory[]"]').empty();
                        $row.find('select[name="subcategory[]"]').append(
                            '<option value="">Select Sub Category</option>'
                        );
                        $.each(data,function(key,value){
                            $row.find('select[name="subcategory[]"]').append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    }
                })
            }else{
                $('select[name="subcategory[]"]').empty();
            }
        });

        //Data According to Sub Category
        $(document).on('change','select[name="subcategory[]"]',function(){
            var category = $(this).val();
            var $row = $(this).closest('.product');

            console.log(category);
            if(category){
                $.ajax({
                    url:'/admin/suppliers/category-items/'+category,
                    type:'GET',
                    dataType:'json',
                    success:function(data){
                        $row.find('select[name="item[]"]').empty();
                        $row.find('select[name="item[]"]').append(
                            '<option value="">Select Item</option>'
                        );
                        $.each(data,function(key,value){
                            $row.find('select[name="item[]"]').append(
                                '<option value="'+value.id+'">'+value.name+'</option>'
                            )
                        });
                    }
                })
            }else{
                $('select[name="item[]"]').empty();
            }
        });
});  
</script>
@endsection
