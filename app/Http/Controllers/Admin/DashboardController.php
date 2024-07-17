<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Enquiry;
use App\Models\Orders;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    //
    public function dashboard()
	{
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $vendors = Vendor::orderBy('id','desc');
        $enquiry = Enquiry::orderBy('id','desc');
        $order = Orders::orderBy('id','desc');
        $customers = Customer::orderBy('id','desc');

        $enquirydata = $enquiry->whereBetween('created_at', [$startDate, $endDate])->paginate(5);
		return view('admin.dashboard',compact('vendors','enquiry','order','enquirydata','customers'));
	}
}
