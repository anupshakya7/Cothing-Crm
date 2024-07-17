<!DOCTYPE html>
<html>

<head>
    <title>Order List</title>
    <style>
        /* Add your CSS styles for the PDF here */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Increase width of the Description column */
        td:nth-child(3) {
            width: 50%;
            /* Adjust this value as needed */
        }
    </style>
    <style>
        .order-products {
            list-style-type: none;
            padding-left: 0;
        }

        .order-products li {
            margin-bottom: 2px;
        }

        .order-notes {
            margin-top: 5px;
            font-style: italic;
            color: #666;
        }

        .size-column {
            width: 50px;
        }
    </style>
</head>

<body style="font-size: 14px;">
    <h1>Order List</h1>
    <table>
        <thead>
            <tr>
                <th>OrderID</th>
                <th>Customer Name</th>
                <th>Description</th>
                <th style="width:50px;">Size</th>
                <th style="width: 60px;">Made By</th>
                <th style="width: 60px;">Due Date</th>

                <!-- Add more table headers as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>

                        <div class="order-notes">
                            {!! $order->order_notes !!}
                        </div>
                    </td>
                    <td style="width:50px;">
                        @isset($order->orderProducts)
                        @php
                        $sizes = [];
                        foreach ($order->orderProducts as $data) {
                            if ($data->measurement_id == -1) {
                                $sizes[] = 'Others';
                            } else {
                                $sizes[] = isset($data->measurement->size) ? $data->measurement->size : '';
                            }
                        }
                        echo implode(', ', $sizes);
                    @endphp
                        @endisset


                    </td>
                    <td></td>
                    <td>
                        @if (isset($order->delivery_date))
                            @php
                                $date = explode('-', $order->delivery_date);
                                $yearDigits = substr($date[0], -2);
                                $monthDigits = str_pad($date[1], 2, '0', STR_PAD_LEFT);
                                $datedigit = $date[2];
                                // Combine year and month digits with the ID and add '#tuk'
                                $dates = $datedigit . '-' . $monthDigits . '-' . $yearDigits;
                            @endphp
                            {{ $dates }}
                        @else
                            -
                        @endif
                    </td>

                    <!-- Add more table data cells as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
