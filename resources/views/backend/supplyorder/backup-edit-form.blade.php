<div class="row">
                                        <div class="col-lg-8">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"
                                                                for="product-title-input">Vendor</label>
                                                            <select class="form-select" id="choices-category-input"
                                                                name="vendor" data-choices data-choices-search-false>
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

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label"
                                                                for="product-title-input">Items</label>
                                                            <select class="form-select" id="choices-categorys-input"
                                                                name="item" data-choices data-choices-search-false>
                                                                <option value="">select Item</option>
                                                                @foreach ($items as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ $item->id == $supplier->supply_item ? 'selected' : '' }}>
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach

                                                            </select>

                                                            <div class="invalid-feedback">{{ $errors->first('item') }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">

                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="product-price-input">Rate</label>
                                                                <div class="input-group has-validation mb-3">
                                                                    <span class="input-group-text"
                                                                        id="product-price-addon">Rs</span>
                                                                    <input type="number" class="form-control"
                                                                        id="product-price-input" placeholder="Enter price"
                                                                        name="price" step="0.01"
                                                                        value="{{ old('price', $supplier->rate) }}"
                                                                        required>
                                                                    <div class="invalid-feedback">
                                                                        {{ $errors->first('price') }}</div>

                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-sm-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="orders-input">Quantity</label>
                                                                <input type="number" class="form-control" id="orders-input"
                                                                    placeholder="Orders" step="0.01" name="quantity"
                                                                    value="{{ old('quantity', $supplier->qty) }}" required>
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('quantity') }}</div>

                                                            </div>
                                                        </div>
                                                        <!-- end col -->
                                                        <div class="col-md-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h5 class="card-title mb-0">Remarks</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <p class="text-muted mb-2">Add Remarks</p>
                                                                    <textarea class="form-control" placeholder="enter the remarks" name="remarks" rows="3">{{ old('remarks', $supplier->remarks) }}</textarea>
                                                                </div>
                                                                <!-- end card body -->
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <!-- end card -->



                                            <!-- end card -->

                                        </div>
                                        <!-- end col -->

                                        <div class="col-lg-4">


                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">Order Date</h5>
                                                </div>
                                                <!-- end card body -->
                                                <div class="card-body">
                                                    <div>
                                                        <label for="datepicker-publish-input"
                                                            class="form-label">Date</label>
                                                        <input type="date" id="datepicker-publish-input"
                                                            name="date" class="form-control"
                                                            value="{{ old('date', $supplier->date) }}"
                                                            placeholder="Enter publish date" data-provider="flatpickr"
                                                            data-date-format="d.m.y" data-enable-time>
                                                    </div>

                                                    <div class="invalid-feedback">{{ $errors->first('date') }}</div>

                                                </div>
                                            </div>
                                            <!-- end card -->
                                            <div class="text-end mb-3">
                                                <button type="submit" class="btn btn-success w-sm">Submit</button>
                                            </div>



                                            <!-- end card -->

                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->