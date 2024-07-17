<!DOCTYPE html>
<html>

<head>
    <title>Order List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js" rel="stylesheet"
        type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        .card {
            margin-bottom: 30px;
            border: none;
            -webkit-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
            -moz-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
            box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e6e6f2;
        }

        h3 {
            font-size: 20px;
        }

        h5 {
            font-size: 15px;
            line-height: 26px;
            color: #3d405c;
            margin: 0px 0px 15px 0px;
            font-family: "Circular Std Medium";
        }

        .text-dark {
            color: #3d405c !important;
        }


        .address-block {
            float: left;
            /* Float left to make blocks appear side by side */
            width: 50%;
            /* Set width to 50% for equal side-by-side layout */
            box-sizing: border-box;
            /* Include padding and border in the width */
            padding: 0 10px;
            /* Add some padding for spacing */
        }
    </style>
</head>

<body>
    <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
        <div class="card">
            <div class="card-header p-4">
                <a class="pt-2 d-inline-block" href="index.html" data-abc="true"><img
                        src="https://tukutukunepal.com/wp-content/uploads/2022/08/tukutuku_logo.png" width="80"
                        height="80"></a>
                <div class="float-right">
                    <h3 class="mb-0">Invoice #{{ $order->order_id }}</h3>
                    Date: {{ $order->ordered_date }}
                </div>
            </div>
            <div class="card-body">
                <div class="address-container mb-4">
                    <div class="address-block">
                        <h5 class="mb-3">From:</h5>
                        <h3 class="text-dark mb-1">TUKU TUKU NEPAL</h3>
                        <div>Boudha, Kathmandu, Nepal</div>
                        <div>Email: info@tukutukunepal.com</div>
                        <div>Phone: +974-5334371</div>
                    </div>
                    <div class="address-block">
                        <h5 class="mb-3">To:</h5>
                        <h3 class="text-dark mb-1">{{ $order->customer_name }}</h3>
                        <div>{{ $order->delivery_address }}</div>
                        @if (isset($order->customer->email))
                            <div>{{ $order->customer->email }}</div>
                        @endif
                        <div>Phone: {{ $order->customer_contact_number }}</div>
                    </div>
                </div>

                <div class="table-responsive-sm" style="margin-top: 30%;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Item</th>
                                <th>Measurement</th>
                                <th class="right">Price</th>
                                <th class="center">Qty</th>
                                <th class="right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = 0)
                            @php($total = 0)
                            @foreach ($productorders as $data)
                                @php($i++)

                                <tr>
                                    <td class="center">{{ $i }}</td>
                                    <td class="left strong">
                                        {{ isset($data->product->name) ? $data->product->name : '' }}</td>
                                    <td class="left">
                                        @if ($data->measurement_id == -1)
                                            Others
                                        @else
                                            {{ isset($data->measurement->size) ? $data->measurement->size : '' }}
                                        @endif
                                    </td>
                                    <td class="right">{{ $data->price }}</td>
                                    <td class="center">{{ $data->quantity }}</td>
                                    <td class="right">Rs.{{ $data->price * $data->quantity }}</td>
                                    @php($total += $data->price * $data->quantity)
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5"></div>
                    <div class="col-lg-4 col-sm-5 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">Subtotal</strong>
                                    </td>
                                    <td class="right">
                                        @php($subtotal = $total / 1.13)
                                        Rs.{{ round($subtotal,2) }}</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">Discount</strong>
                                    </td>
                                    <td class="right">Rs.{{ round($order->discount,2) }}</td>
                                </tr>

                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">Taxable Amount</strong>
                                    </td>
                                    <td class="right">
                                        @php($tax_discountdiscout = $order->discount ? $order->discount/1.13 : $order->discount)
                                        @php($taxable_amount = $subtotal - $tax_discountdiscout)
                                        Rs.{{ round($taxable_amount,2) }}</td>
                                </tr>

                                <tr>
                                    <td class="left">
                                        @php($main_vat = ($taxable_amount * 0.13))
                                        <strong class="text-dark">VAT (13%)</strong>
                                    </td>
                                    <td class="right"> Rs.{{ round($main_vat,2) }}</td>
                                </tr>


                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">Total</strong>
                                    </td>
                                    <td class="right">
                                        <strong class="text-dark">Rs.{{ round($taxable_amount + $main_vat,2) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white">
                <p class="mb-0">Customer Care: info@tukutukunepal.com +974-5334371 </p>
            </div>
        </div>
    </div>
</body>

</html>
