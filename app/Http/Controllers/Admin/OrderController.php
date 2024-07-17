<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeliveryPartner;
use App\Models\Measurement;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderProducts;
use App\Models\Orders;
use App\Models\Product;
use App\Models\Products;
use App\Models\Trailer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Krishnahimself\DateConverter\DateConverter;
use Shankhadev\Bsdate\BsdateFacade;
use App\Rules\NotAllZeros;

class OrderController extends Controller
{
    public function index(Request $request)
    {



        // if (!request()->user()->hasPermissionTo('user.list')) {
        //     abort(401, 'You have not permission to list of the user !');
        // }

        $query = Orders::query()
            ->orderByDesc('ordered_date')
            ->orderByDesc(DB::raw("CAST(SUBSTRING_INDEX(order_id, '-', 1) AS UNSIGNED)"));

        switch ($request->input('tab')) {
            case 'Pickups':
                // Adjust query for pickups
                $query->where('status', 'Inprogress');
                break;
            case 'Hold':
                // Adjust query for Hold
                $query->where('status', 'Hold');
                break;
            case 'Pending':
                // Adjust query for pending
                $query->where('status', 'Pending');
                break;
            case 'Delivered':
                // Adjust query for delivered
                $query->where('status', 'Delivered');
                break;
            case 'Completed':
                // Adjust query for Completed
                $query->where('status', 'Completed');
                break;
            case 'Returns':
                // Adjust query for returns
                $query->where('status', 'Returned');
                break;
            case 'Cancelled':
                // Adjust query for cancelled
                $query->where('status', 'Cancelled');
                break;
            default:
                // No tab clicked, default to All
                // You can adjust this to your default behavior
                break;
        }

        if ($request->filled('order_id')) {
            $query->where('order_id', 'like', '%' . $request->input('order_id') . '%');
        }

        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->input('customer_name') . '%');
        }

        // Filter by contact number
        if ($request->filled('contact_number')) {
            $query->where('customer_contact_number', 'like', '%' . $request->input('contact_number') . '%');
        }

        // Filter by order date
        if ($request->filled('orderdate')) {
            $query->whereDate('ordered_date', $request->input('orderdate'));
        }

        // Filter by product
        if ($request->filled('product')) {
            $orderId = OrderProducts::select('order_id')
                ->where('product_id', $request->input('product'))
                ->groupBy('order_id')
                ->get()
                ->pluck('order_id'); // Extracting only order_id values from the result

            if ($orderId->isNotEmpty()) { // Check if $orderId is not empty
                $query->whereIn('id', $orderId);
            }
        }

        // Filter by handled by (trailer)
        if ($request->filled('handleby')) {
            $query->where('handled_by', $request->input('handleby'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', 'like', '%' . $request->input('status') . '%');
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', 'like', '%' . $request->input('priority') . '%');
        }

        if ($request->filled('fromDate') && $request->filled('toDate')) {
            $fromdate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $query->whereBetween('ordered_date', [$fromdate, $toDate]);
        }


        $ordercount = $query->count();
        $orders = $query->paginate(50);
        $products = Products::where('status', 'Active')->get();
        $trailers = Trailer::where('status', 'Active')->get();
        $delivery_partners = DeliveryPartner::get();
        return view('backend.order.index', compact('orders', 'products', 'trailers', 'delivery_partners', 'ordercount'));
    }

    public function report(Request $request)
    {
        $daily_date = $request->filled('daily_date') ? $request->input('daily_date') : '';
        $month_date = $request->filled('month_date') ? $request->input('month_date') : '';
        $year_date = $request->filled('year_date') ? $request->input('year_date') : '';
        $last_year  = '';
        $startOfWeek_day = '';
        $endOfWeek_day = '';
        $weekOffset = $request->filled('weekOffset') ? $request->input('weekOffset') : 0;
        $query = Orders::query()
            ->orderByDesc('ordered_date')
            ->orderByDesc(DB::raw("CAST(SUBSTRING_INDEX(order_id, '-', 1) AS UNSIGNED)"));

        if ($request->filled('order_id')) {
            $query->where('orders.order_id', 'like', '%' . $request->input('order_id') . '%');
        }

        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->input('customer_name') . '%');
        }

        if ($request->filled('contact_number')) {
            $query->where('customer_contact_number', 'like', '%' . $request->input('contact_number') . '%');
        }

        if ($request->filled('orderdate')) {
            $query->whereDate('ordered_date', $request->input('orderdate'));
        }

        if ($request->filled('product')) {
            $query->whereIn('id', function ($subQuery) use ($request) {
                $subQuery->select('order_id')
                    ->from('order_products')
                    ->where('product_id', $request->input('product'))
                    ->groupBy('order_id');
            });
        }

        if ($request->filled('handleby')) {
            $query->where('handled_by', $request->input('handleby'));
        }

        if ($request->filled('priority')) {
            $query->where('priority', 'like', '%' . $request->input('priority') . '%');
        }

        if ($request->filled('fromDate') && $request->filled('toDate')) {
            $fromdate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $query->whereBetween('ordered_date', [$fromdate, $toDate]);
        }

        if ($request->filled('status')) {
            $query->where('status', 'like', '%' . $request->input('status') . '%');
        }

        $today_date = date('Y-m-d');
        $date = DateConverter::fromEnglishDate(date('Y', strtotime($today_date)), date('m', strtotime($today_date)), date('d', strtotime($today_date)))->toNepaliDate();
        $last_year  = date('Y', strtotime($date));

        if ($request->input('date_type') == 'Daily') {
            if ($daily_date) {
                $query->whereDate('ordered_date', $daily_date);
            } else {
                $today_date = date('Y-m-d');
                $daily_date = DateConverter::fromEnglishDate(date('Y', strtotime($today_date)), date('m', strtotime($today_date)), date('d', strtotime($today_date)))->toNepaliDate();
                $query->whereDate('ordered_date', $daily_date);
            }
        }

        if ($request->input('date_type') == 'Weekly') {
            $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($weekOffset)->format('Y-m-d');
            $endOfWeek = Carbon::now()->endOfWeek()->addWeeks($weekOffset)->format('Y-m-d');

            if ($startOfWeek && $endOfWeek) {
                $nepaliDate = DateConverter::fromEnglishDate(date('Y', strtotime($startOfWeek)), sprintf('%02d', date('m', strtotime($startOfWeek))), date('d', strtotime($startOfWeek)))->toNepaliDate();
                $endnepaliDate = DateConverter::fromEnglishDate(date('Y', strtotime($endOfWeek)), sprintf('%02d', date('m', strtotime($endOfWeek))), date('d', strtotime($endOfWeek)))->toNepaliDate();

                $nepaliDateParts = explode('-', $nepaliDate);
                $year = $nepaliDateParts[0];
                $month = sprintf('%02d', $nepaliDateParts[1]);
                $day = $nepaliDateParts[2];
                $startOfWeek_day = "{$year}-{$month}-{$day}";

                $endnepaliDateParts = explode('-', $endnepaliDate);
                $endyear = $endnepaliDateParts[0];
                $endmonth = sprintf('%02d', $endnepaliDateParts[1]);
                $endday = $endnepaliDateParts[2];
                $endOfWeek_day = "{$endyear}-{$endmonth}-{$endday}";

                $query->whereBetween('ordered_date', [$startOfWeek_day, $endOfWeek_day]);
            }
        }

        if ($request->input('date_type') == 'Monthly') {
            if ($month_date) {
                $year_month_data = $year_date . '-' . $month_date;
                $query->where('ordered_date', 'like', $year_month_data . '%');
            } else {
                $year_date = $date;
                $year_date = date('Y', strtotime($year_date));
                $today_date = date('Y-m-d');
                $month_date = DateConverter::fromEnglishDate(date('Y', strtotime($today_date)), date('m', strtotime($today_date)), date('d', strtotime($today_date)))->toNepaliDate();
                $month_date = date('m', strtotime($month_date));
                $year_month_data = $year_date . '-' . $month_date;

                $query->where('ordered_date', 'like', $year_month_data . '%');
            }
        }

        if ($request->input('date_type') == 'Yearly') {
            if ($year_date) {
                $query->where('ordered_date', 'like', $year_date . '%');
            } else {
                $year_date = $date;
                $year_date = date('Y', strtotime($year_date));
                $query->where('ordered_date', 'like', $year_date . '%');
            }
        }

        $total_sum = $query->sum('total_price');
        $receivable_amount = $query->sum('receivable_amount');
        $delivery_amount = $query->sum('delivery_charge');

        $queryClone = clone $query;
        $advance_sum = $queryClone->join('order_payments', 'orders.id', '=', 'order_payments.order_id')
            ->sum('order_payments.amount');

        $orders = $query->paginate(50);

        $counts = $this->getOrderCounts($request);

        $products = Products::where('status', 'Active')->get();
        $trailers = Trailer::where('status', 'Active')->get();
        $delivery_partners = DeliveryPartner::get();

        return view('backend.order.report', compact(
            'total_sum',
            'receivable_amount',
            'delivery_amount',
            'advance_sum',
            'orders',
            'weekOffset',
            "endOfWeek_day",
            "startOfWeek_day",
            'last_year',
            'products',
            'trailers',
            'delivery_partners',
            'daily_date',
            'month_date',
            'year_date'
        ) + $counts);
    }


    private function getOrderCounts($request)
    {
        $baseQuery = Orders::query();

        if ($request->filled('order_id')) {
            $baseQuery->where('order_id', 'like', '%' . $request->input('order_id') . '%');
        }

        if ($request->filled('customer_name')) {
            $baseQuery->where('customer_name', 'like', '%' . $request->input('customer_name') . '%');
        }

        if ($request->filled('contact_number')) {
            $baseQuery->where('customer_contact_number', 'like', '%' . $request->input('contact_number') . '%');
        }

        if ($request->filled('orderdate')) {
            $baseQuery->whereDate('ordered_date', $request->input('orderdate'));
        }

        if ($request->filled('product')) {
            $baseQuery->whereIn('id', function ($subQuery) use ($request) {
                $subQuery->select('order_id')
                    ->from('order_products')
                    ->where('product_id', $request->input('product'))
                    ->groupBy('order_id');
            });
        }

        if ($request->filled('handleby')) {
            $baseQuery->where('handled_by', $request->input('handleby'));
        }
        $daily_date = $request->filled('daily_date') ? $request->input('daily_date') : '';
        $month_date = $request->filled('month_date') ? $request->input('month_date') : '';
        $year_date = $request->filled('year_date') ? $request->input('year_date') : '';
        $weekOffset = $request->filled('weekOffset') ? $request->input('weekOffset') : 0;

        if ($request->input('date_type') == 'Daily') {

            if ($daily_date) {
                $baseQuery->whereDate('ordered_date', $daily_date);
            } else {
                $today_date = date('Y-m-d');
                $daily_date = DateConverter::fromEnglishDate(date('Y', strtotime($today_date)), date('m', strtotime($today_date)), date('d', strtotime($today_date)))->toNepaliDate();
                $baseQuery->whereDate('ordered_date', $daily_date);
            }
        }

        if ($request->input('date_type') == 'Weekly') {
            $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($weekOffset)->format('Y-m-d');
            $endOfWeek = Carbon::now()->endOfWeek()->addWeeks($weekOffset)->format('Y-m-d');
            if ($startOfWeek && $endOfWeek) {
                $nepaliDate = DateConverter::fromEnglishDate(date('Y', strtotime($startOfWeek)), sprintf('%02d', date('m', strtotime($startOfWeek))), date('d', strtotime($startOfWeek)))->toNepaliDate();
                $endnepaliDate = DateConverter::fromEnglishDate(date('Y', strtotime($endOfWeek)), sprintf('%02d', date('m', strtotime($endOfWeek))), date('d', strtotime($endOfWeek)))->toNepaliDate();
                $nepaliDateParts = explode('-', $nepaliDate);
                $year = $nepaliDateParts[0];
                $month = sprintf('%02d', $nepaliDateParts[1]); // Ensure double digits for month
                $day = $nepaliDateParts[2];
                // Now, reconstruct the Nepali date string with the formatted month
                $startOfWeek_day = "{$year}-{$month}-{$day}";

                $endnepaliDateParts = explode('-', $endnepaliDate);
                $endyear = $endnepaliDateParts[0];
                $endmonth = sprintf('%02d', $endnepaliDateParts[1]); // Ensure double digits for endmonth
                $endday = $endnepaliDateParts[2];
                // Now, reconstruct the Nepali date string with the formatted month
                $endOfWeek_day = "{$endyear}-{$endmonth}-{$endday}";
                $baseQuery->whereBetween('ordered_date', [$startOfWeek_day, $endOfWeek_day]);
            }
        }

        $today_date = date('Y-m-d');
        $date = DateConverter::fromEnglishDate(date('Y', strtotime($today_date)), date('m', strtotime($today_date)), date('d', strtotime($today_date)))->toNepaliDate();

        if ($request->input('date_type') == 'Monthly') {
            if ($month_date) {
                $year_month_data = $year_date . '-' . $month_date;
                $baseQuery->where('ordered_date', 'like', $year_month_data . '%');
            } else {
                $year_date = $date;
                $year_date = date('Y', strtotime($year_date));
                $today_date = date('Y-m-d');
                $month_date = DateConverter::fromEnglishDate(date('Y', strtotime($today_date)), date('m', strtotime($today_date)), date('d', strtotime($today_date)))->toNepaliDate();
                $month_date = date('m', strtotime($month_date));
                $year_month_data = $year_date . '-' . $month_date;
                $baseQuery->where('ordered_date', 'like', $year_month_data . '%');
            }
        }

        if ($request->input('date_type') == 'Yearly') {

            if ($year_date) {
                $baseQuery->where('ordered_date', 'like', $year_date . '%');
            } else {
                $today_date = date('Y-m-d');
                $month_date = DateConverter::fromEnglishDate(date('Y', strtotime($today_date)), date('m', strtotime($today_date)), date('d', strtotime($today_date)))->toNepaliDate();
                $year_month_data = date('Y', strtotime($month_date));
                $baseQuery->where('ordered_date', 'like', $year_month_data . '%');
            }
        }


        if ($request->filled('fromDate') && $request->filled('toDate')) {
            $fromdate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $baseQuery->whereBetween('ordered_date', [$fromdate, $toDate]);
        }

        $counts = [
            'ordercount' => $baseQuery->count(),
            'inprogresscount' => (clone $baseQuery)->where('status', 'Inprogress')->count(),
            'pendingcount' => (clone $baseQuery)->where('status', 'Pending')->count(),
            'holdcount' => (clone $baseQuery)->where('status', 'Hold')->count(),
            'deliveredcount' => (clone $baseQuery)->where('status', 'Delivered')->count(),
            'completedcount' => (clone $baseQuery)->where('status', 'Completed')->count(),
            'returncount' => (clone $baseQuery)->where('status', 'Returned')->count(),
            'cancelledcount' => (clone $baseQuery)->where('status', 'Cancelled')->count()
        ];

        return $counts;
    }



    public function daily(Request $request)
    {



        // if (!request()->user()->hasPermissionTo('user.list')) {
        //     abort(401, 'You have not permission to list of the user !');
        // }

        $query = Orders::query()->orderBy('id', 'DESC');

        switch ($request->input('tab')) {
            case 'Pickups':
                // Adjust query for pickups
                $query->where('status', 'Inprogress');
                break;
            case 'Pending':
                // Adjust query for pending
                $query->where('status', 'Pending');
                break;
            case 'Delivered':
                // Adjust query for delivered
                $query->where('status', 'Delivered');
                break;
            case 'Completed':
                // Adjust query for Completed
                $query->where('status', 'Completed');
                break;
            case 'Returns':
                // Adjust query for returns
                $query->where('status', 'Returned');
                break;
            case 'Cancelled':
                // Adjust query for cancelled
                $query->where('status', 'Cancelled');
                break;
            default:
                // No tab clicked, default to All
                // You can adjust this to your default behavior
                break;
        }

        if ($request->filled('order_id')) {
            $query->where('order_id', 'like', '%' . $request->input('order_id') . '%');
        }

        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->input('customer_name') . '%');
        }

        // Filter by contact number
        if ($request->filled('contact_number')) {
            $query->where('customer_contact_number', 'like', '%' . $request->input('contact_number') . '%');
        }

        // Filter by order date
        if ($request->filled('orderdate')) {
            $query->whereDate('ordered_date', $request->input('orderdate'));
        }

        // Filter by product
        if ($request->filled('product')) {
            $query->where('product_id', $request->input('product'));
        }

        // Filter by handled by (trailer)
        if ($request->filled('handleby')) {
            $query->where('handled_by', $request->input('handleby'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', 'like', '%' . $request->input('status') . '%');
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', 'like', '%' . $request->input('priority') . '%');
        }

        if ($request->filled('fromDate') && $request->filled('toDate')) {
            $fromdate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $query->whereBetween('ordered_date', [$fromdate, $toDate]);
        } else {
            if ($request->filled('orderdate')) {
                $query->whereDate('ordered_date', $request->input('orderdate'));
            } else {
                $query->where('ordered_date', date('Y-m-d'));
            }
        }



        $orders = $query->paginate(5);
        $products = Products::where('status', 'Active')->get();
        $trailers = Trailer::where('status', 'Active')->get();
        $delivery_partners = DeliveryPartner::get();
        return view('backend.order.daily', compact('orders', 'products', 'trailers', 'delivery_partners'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = request()->user();

        // Check if logged in user has "user.create" permission or not
        // if (!request()->user()->hasPermissionTo('user.create')) {
        //     abort(401, 'You have not permission to create a user !');
        // }
        $products = Products::where('status', 'Active')->get();
        $trailers = Trailer::where('status', 'Active')->get();
        $delivery_partners = DeliveryPartner::get();
        $measurements = Measurement::where('status', 'Active')->get();

        return view('backend.order.create', compact('products', 'trailers', 'delivery_partners', 'measurements'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        // if (!request()->user()->hasPermissionTo('user.create')) {
        //     abort(401, 'You have not permission to create a user !');
        // }

        // Validate our data
        $request->validate(
            [
                'customer_name' => 'required|string|max:255|min:2',
                'customer_number' => ['nullable', 'numeric', new NotAllZeros],
                'order_date' => 'required|string',
                'order_id' => 'required|string|unique:orders,order_id',
                'delivery_address' => 'required|string',
                'total_amount' => 'nullable|numeric',
                'outstading_amount' => 'nullable|numeric',
                'receivable_amount' => 'nullable|numeric',
                'extra_charge' => 'nullable|numeric',
                'status' => 'required|string',
                'priority' => 'required|string',
                'product_handled_by' => 'required|integer',

            ],

        );

        $customer = Customer::whereRaw('LOWER(customer_contact_number) = ?', strtolower($request->customer_number))
            ->whereRaw('LOWER(customer_name) = ?', strtolower($request->customer_name))
            ->first();
        if (!$customer) {
            $customer = new Customer();
            $customer->customer_name = $request->customer_name;
            $customer->customer_contact_number = $request->customer_number;
            $customer->address = $request->delivery_address;
            $customer->source = "Manual";
            $customer->save();
        }
        // If validated, insert data
        $vendor = new Orders();
        $vendor->customer_id = $customer->id;
        $vendor->customer_name = $request->customer_name;
        $vendor->ordered_date = $request->order_date;
        if ($request->order_date) {
            $explode_date = explode("-", $request->order_date);
            $adDate = BsdateFacade::nep_to_eng($explode_date[0], $explode_date[1], $explode_date[2]);
            $year = $adDate['year'];
            $month = str_pad($adDate['month'], 2, '0', STR_PAD_LEFT); // Ensure month is two digits
            $date = str_pad($adDate['date'], 2, '0', STR_PAD_LEFT); // Ensure date is two digits
            $english_date = "$year-$month-$date";
            $vendor->english_date = $english_date;
        }
        $vendor->customer_contact_number = $request->customer_number;
        $vendor->delivery_remarks = $request->delivery_remarks;
        $vendor->delivery_address = $request->delivery_address;
        $order_id = Orders::generateOrderId($request->order_id, $request->order_date);
        $vendor->order_id = $order_id;
        $vendor->total_price = $request->total_amount;
        $vendor->outstading_price    = $request->outstading_amount;
        $vendor->receivable_amount = $request->receivable_amount;
        $vendor->receivable_payment_method = $request->receivable_payment_method;
        $vendor->order_notes = $request->order_notes;
        $vendor->handled_by = $request->product_handled_by;
        $vendor->status = $request->status;
        $vendor->priority = $request->priority;
        // $vendor->advance = $request->advance;
        // $vendor->payment_method = $request->payment_method;
        $vendor->discount = $request->discount_amount;
        // $vendor->payment_status = $request->payment_status;
        // $vendor->payment_date = $request->payment_date;
        $vendor->delivery_partner_id = $request->delivery_partner;
        $vendor->delivery_date = $request->delivery_date;
        $vendor->delivery_charge = $request->delivery_charge;
        $vendor->extra_charge = $request->extra_charge;

        $vendor->save();

        if ($request->product) {
            foreach ($request->product as $key => $productId) {
                // Assuming FollowUpDate is the model for your productorder table
                $productOrder = new OrderProducts();
                $productOrder->product_id = $productId;
                $productOrder->order_id = $vendor->id;
                $productOrder->measurement_id = $request->measurement[$key];
                $productOrder->price = $request->price[$key];
                $productOrder->quantity = $request->quantity[$key];
                $productOrder->save();
            }
        }

        if ($request->payment_method) {
            foreach ($request->payment_method as $key => $payment_method) {
                // Assuming FollowUpDate is the model for your productorder table
                $productOrder = new OrderPayment();
                $productOrder->payment_method = $payment_method;
                $productOrder->order_id = $vendor->id;
                $productOrder->amount = isset($request->amount[$key]) ? $request->amount[$key] : 0;
                $productOrder->payment_date = isset($request->payment_date[$key]) ? $request->payment_date[$key] : null;
                $productOrder->payment_received_by = isset($request->payment_received_by[$key]) ? $request->payment_received_by[$key] : null;
                $productOrder->is_advance = isset($request->is_advance[$key]) ? 1 : null;
                $productOrder->save();
            }
        }


        session()->flash('success', 'Order has been created !');
        return redirect()->route('admin.order.index');
    }

    public function edit($id)
    {
        $order = Orders::find($id);
        $products = Products::where('status', 'Active')->get();
        $trailers = Trailer::where('status', 'Active')->get();
        $delivery_partners = DeliveryPartner::get();
        $measurements = Measurement::where('status', 'Active')->get();
        $productorders = OrderProducts::where('order_id', $id)->get();
        $orderpayment = OrderPayment::where('order_id', $id)->get();


        if (!is_null($order)) {
            return view('backend.order.edit', compact('order', 'products', 'trailers', 'delivery_partners', 'measurements', 'productorders', 'orderpayment'));
        }

        session()->flash('error', 'Sorry ! No trailer has been found !');
        return redirect()->route('admin.trailer.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $vendor = Orders::find($id);

        if (!is_null($vendor)) {
            // Validate our data
            $request->validate(
                [
                    'customer_name' => 'required|string|max:255|min:2',
                    'customer_number' => ['nullable', 'numeric', new NotAllZeros],
                    'order_date' => 'required|string',
                    'order_id' => 'required|string|unique:orders,order_id,' . $id,
                    'delivery_address' => 'required|string',
                    // 'product' => 'required|integer',
                    // 'measurement' => 'required|integer',
                    // 'quantity' => 'required|numeric',
                    // 'price' => 'nullable|numeric',
                    'total_amount' => 'nullable|numeric',
                    'outstading_amount' => 'nullable|numeric',
                    'receivable_amount' => 'nullable|numeric',
                    'extra_charge' => 'nullable|numeric',
                    'status' => 'required|string',
                    'priority' => 'required|string',
                    'product_handled_by' => 'required|integer',

                ],

            );
            $customer = Customer::where('id', $vendor->customer_id)->first();
            if (!$customer) {
                $customer = new Customer();
                $customer->customer_name = $request->customer_name;
                $customer->customer_contact_number = $request->customer_number;
                $customer->address = $request->delivery_address;
                $customer->source = "Manual";
                $customer->save();
            }else{
                $customer->customer_name = $request->customer_name;
                $customer->customer_contact_number = $request->customer_number;
                $customer->address = $request->delivery_address;
                $customer->save();

            }
            // If validated, insert data
            $vendor->customer_id = $customer->id;

            $vendor->customer_name = $request->customer_name;
            $vendor->ordered_date = $request->order_date;
            if ($request->order_date) {
                $explode_date = explode("-", $request->order_date);
                $adDate = BsdateFacade::nep_to_eng($explode_date[0], $explode_date[1], $explode_date[2]);
                $year = $adDate['year'];
                $month = str_pad($adDate['month'], 2, '0', STR_PAD_LEFT); // Ensure month is two digits
                $date = str_pad($adDate['date'], 2, '0', STR_PAD_LEFT); // Ensure date is two digits
                $english_date = "$year-$month-$date";
                $vendor->english_date = $english_date;
            }
            $vendor->customer_contact_number = $request->customer_number;
            $vendor->delivery_remarks = $request->delivery_remarks;
            $vendor->delivery_address = $request->delivery_address;
            $vendor->discount = $request->discount_amount;
            // $vendor->product_id = $request->product;
            // $vendor->measurement_id = $request->measurement;
            // $vendor->quantity = $request->quantity;
            // if ($request->price) {
            //     $vendor->price = $request->price;
            // } else {
            //     $product = Products::findOrFail($request->product);
            //     $vendor->price = $product->price;
            // }
            $vendor->total_price = $request->total_amount;
            $vendor->outstading_price    = $request->outstading_amount;
            $vendor->receivable_amount = $request->receivable_amount;
            $vendor->receivable_payment_method = $request->receivable_payment_method;
            if ($request->order_id) {
                $vendor->order_id = $request->order_id;
            } else {
                $order_id = Orders::generateOrderId($request->order_id, $request->order_date);
                $vendor->order_id = $order_id;
            }
            $vendor->order_notes = $request->order_notes;
            $vendor->handled_by = $request->product_handled_by;
            $vendor->status = $request->status;
            $vendor->priority = $request->priority;
            // $vendor->advance = $request->advance;
            // $vendor->payment_method = $request->payment_method;
            // $vendor->payment_status = $request->payment_status;
            // $vendor->payment_date = $request->payment_date;
            $vendor->delivery_partner_id = $request->delivery_partner;
            $vendor->delivery_date = $request->delivery_date;
            $vendor->delivery_charge = $request->delivery_charge;
            $vendor->extra_charge = $request->extra_charge;
            $vendor->save();
            OrderProducts::where('order_id', $id)->delete();
            if ($request->product) {
                foreach ($request->product as $key => $productId) {
                    // Assuming FollowUpDate is the model for your productorder table
                    $productOrder = new OrderProducts();
                    $productOrder->product_id = $productId;
                    $productOrder->order_id = $id;
                    $productOrder->measurement_id = $request->measurement[$key];
                    $productOrder->price = $request->price[$key];
                    $productOrder->quantity = $request->quantity[$key];
                    $productOrder->save();
                }
            }

            OrderPayment::where('order_id', $id)->delete();
            if ($request->payment_method) {
                foreach ($request->payment_method as $key => $payment_method) {
                    // Assuming FollowUpDate is the model for your productorder table
                    $productOrder = new OrderPayment();
                    $productOrder->payment_method = $payment_method;
                    $productOrder->order_id = $id;
                    $productOrder->amount = isset($request->amount[$key]) ? $request->amount[$key] : 0;
                    $productOrder->payment_date = isset($request->payment_date[$key]) ? $request->payment_date[$key] : null;
                    $productOrder->payment_received_by = isset($request->payment_received_by[$key]) ? $request->payment_received_by[$key] : null;
                    $productOrder->is_advance = isset($request->is_advance[$key]) ? 1 : null;
                    $productOrder->save();
                }
            }
            session()->flash('success', 'Order has been updated !');
        } else {
            session()->flash('error', 'Sorry ! No trailer has been found !');
        }
        return redirect()->route('admin.order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $vendor = Orders::find($id);
        if (!is_null($vendor)) {
            // First Delete User Image & then Delete the user
            $vendor->delete();
            OrderProducts::where('order_id', $id)->delete();
            OrderPayment::where('order_id', $id)->delete();

            session()->flash('success', 'Order has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No Order has been found !');
        }
        return redirect()->route('admin.order.index');
    }


    public function fetchCustomerData(Request $request)
    {
        $customerNumber = $request->input('customer_number');

        $customer = Customer::where('customer_contact_number', $customerNumber)->first();

        if ($customer) {
            return response()->json([
                'success' => true,
                'data' => [
                    'name' => $customer->customer_name,
                    'address' => $customer->address
                ]
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function product($id)
    {

        $product = Product::where('id', $id)->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'data' => $product->price
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }


    public function generateOrderListPDF(Request $request)
    {
        $query = Orders::query()
            ->orderByDesc('ordered_date')
            ->orderByDesc(DB::raw("CAST(SUBSTRING_INDEX(order_id, '-', 1) AS UNSIGNED)"));

        switch ($request->input('tab')) {
            case 'Pickups':
                // Adjust query for pickups
                $query->where('status', 'Inprogress');
                break;
            case 'Hold':
                // Adjust query for Hold
                $query->where('status', 'Hold');
                break;
            case 'Pending':
                // Adjust query for pending
                $query->where('status', 'Pending');
                break;
            case 'Delivered':
                // Adjust query for delivered
                $query->where('status', 'Delivered');
                break;
            case 'Completed':
                // Adjust query for Completed
                $query->where('status', 'Completed');
                break;
            case 'Returns':
                // Adjust query for returns
                $query->where('status', 'Returned');
                break;
            case 'Cancelled':
                // Adjust query for cancelled
                $query->where('status', 'Cancelled');
                break;
            default:
                // No tab clicked, default to All
                // You can adjust this to your default behavior
                break;
        }

        if ($request->filled('fromDate') && $request->filled('toDate')) {
            $fromdate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $query->whereBetween('ordered_date', [$fromdate, $toDate]);
        }
        if ($request->filled('date')) {
            $fromdate = $request->input('date');
            $query->where('ordered_date', $fromdate);
        }

        $orders = $query->get(); // Assuming you have an Order model

        $pdf = PDF::loadView('backend.order.order-list-pdf', compact('orders'))->setPaper('a4', 'portrait');

        return $pdf->download('order-list.pdf');
    }

    public function print(Request $request)
    {
        $orderIds = $request->input('order_ids');
        $orders = Orders::whereIn('id', $orderIds)->get();

        $pdf = PDF::loadView('backend.order.order-list-pdf', compact('orders'))->setPaper('a4', 'portrait');

        return $pdf->download('order-list.pdf');
    }





    public function generateOrderInvoice($id)
    {
        $order = Orders::where('id', $id)->firstorfail();
        $productorders = OrderProducts::where('order_id', $id)->get();
        $pdf = PDF::loadView('backend.order.order_invoice', compact('order', 'productorders'))->setPaper('a4', 'portrait')->setOption([
            'dpi' => 150, 'defaultFont' => 'sans-serif',
            'headerHtml' => '',
            'footerHtml' => ''
        ]);
        return $pdf->download('order-invoice.pdf');
    }


    public function transferOrder()
    {
        // Fetch orders in batches

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Retrieve records where order_date is in BS calendar
            $records = Orders::whereNotNull('ordered_date')->get();

            // Iterate through each record
            foreach ($records as $record) {
                // Convert order_date from BS to AD
                $explode_date = explode("-", $record->ordered_date);
                $adDate = BsdateFacade::nep_to_eng($explode_date[0], $explode_date[1], $explode_date[2]);
                $year = $adDate['year'];
                $month = str_pad($adDate['month'], 2, '0', STR_PAD_LEFT); // Ensure month is two digits
                $date = str_pad($adDate['date'], 2, '0', STR_PAD_LEFT); // Ensure date is two digits

                // Format as yyyy-mm-dd
                $formatted_date = "$year-$month-$date";

                // Update the english_date column with AD date
                $record->update(['english_date' => $formatted_date]);
            }
            // Commit the transaction
            DB::commit();

            return redirect()->route('admin.order.index');
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();
            dd($e);


            return response()->json(['error' => 'Failed to transfer orders.'], 500);
        }
    }
}
