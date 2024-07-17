<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuppliersOrder;
use App\Models\Vendor;
use App\Models\VendorPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorPaymentController extends Controller
{
    //Index Function
    public function index()
    {
        $payments = SuppliersOrder::with(['VendorPayment'=>function($query){
            $query->select('vendor_id',DB::raw('MAX(id) as id'),DB::raw('MAX(date) as date'),DB::raw('SUM(total_amount) as total_amount'),DB::raw('SUBSTRING_INDEX(GROUP_CONCAT(received_by ORDER BY id DESC),",",1) as received_by'),DB::raw('SUBSTRING_INDEX(GROUP_CONCAT(received_method ORDER BY id DESC),",",1) as received_method'),DB::raw('SUBSTRING_INDEX(GROUP_CONCAT(remarks ORDER BY id DESC),"," ,1) as remarks'))->groupBy('vendor_id')->latest()->get();
        },'Vendor'])->select('vendor_id',DB::raw('MAX(date) as latest_date'))->groupBy('vendor_id')->latest()->get();

        // $sumAmounts = VendorPayment::select('vendor_id',DB::raw('SUM(total_amount) as sum_total_amount'))->groupBy('vendor_id')->pluck('sum_total_amount','vendor_id');
        // $payments = VendorPayment::whereIn('id',function($query){
        //     $query->select(DB::raw('MAX(id)'))->from('vendor_payments')->groupBy('vendor_id');
        // })->get();

        // foreach($payments as $payment){
        //     $payment->total_amount = $sumAmounts[$payment->vendor_id] ?? 0;
        // }        

        return view('backend.suppliers.payment.index', compact('payments'));
    }

    //Create Function
    public function create()
    {
        $user = request()->user();
        $vendors = Vendor::where('status', 'Active')->get();

        return view('backend.suppliers.payment.create', compact('vendors'));
    }

    //Store Function
    public function store(Request $request)
    {
        // Validate our data
        $request->validate(
            [
                'vendor' => 'required',
                'amount' => 'required',
                'date' => 'required',
                'received_by' => 'required|string|max:255|min:2',
                'received_method' => 'required|string|max:255|min:2'
            ],

        );

        // If validated, insert data
        $payment = new VendorPayment();
        $payment->vendor_id = $request->vendor;
        $payment->total_amount = $request->amount;
        $payment->date = $request->date;
        $payment->received_by = $request->received_by;
        $payment->received_method = $request->received_method;
        $payment->remarks = $request->remarks;
        $payment->save();

        session()->flash('success', 'Vendor Payment has been created !');
        return redirect()->route('admin.vendors-payment.index');
    }

    //Detail Function
    public function detail($vendor_id)
    {
        $vendor = Vendor::with(['SupplyOrders' => function ($query) {
            $query->select('vendor_id', DB::raw('SUM(total_price) as total_amount'))->groupBy('vendor_id')->first();
        }])->where('id', $vendor_id)->first();
        $query = VendorPayment::query();
        if (!empty($vendor_id)) {
            $query->select('id', 'total_amount', 'date', 'received_by', 'received_method', 'remarks')->where('vendor_id', $vendor_id);
        }
        $payments = $query->get();
        $sumTotal = $query->sum('total_amount');

        return view('backend.suppliers.payment.detail', compact('vendor', 'payments', 'sumTotal'));
    }

    //Edit Function
    public function edit($id)
    {
        $payment = VendorPayment::find($id);
        $vendors = Vendor::where('status', 'Active')->get();
        if (!is_null($payment)) {
            return view('backend.suppliers.payment.edit', compact('payment', 'vendors'));
        }

        session()->flash('error', 'Sorry ! No Vendor Payment has been found !');
        return redirect()->route('admin.vendors-payment.index');
    }

    //Update Function
    public function update(Request $request, $id)
    {
        $payment = VendorPayment::find($id);

        if (!is_null($payment)) {
            // Validate our data
            $request->validate(
                [
                    'vendor' => 'required',
                    'amount' => 'required',
                    'date' => 'required',
                    'received_by' => 'required|string|max:255|min:2',
                    'received_method' => 'required|string|max:255|min:2'
                ],

            );

            $vendor_id = $request->vendor;

            // If validated, insert data
            $payment->vendor_id = $vendor_id;
            $payment->total_amount = $request->amount;
            $payment->date = $request->date;
            $payment->received_by = $request->received_by;
            $payment->received_method = $request->received_method;
            $payment->remarks = $request->remarks;
            $payment->save();

            session()->flash('success', 'Vendor Payment has been updated !');
        } else {
            session()->flash('error', 'Sorry ! No Vendor Payment has been found !');
        }
        return redirect()->route('admin.vendors-payment.detail', compact('vendor_id'));
    }

    //Destroy Function
    public function destroy($id)
    {
        $payment = VendorPayment::find($id);
        $vendor = $payment->vendor_id;
        if (!is_null($payment)) {
            // First Delete User Image & then Delete the user
            $payment->delete();
            session()->flash('success', 'vendor payment has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No vendor payment has been found !');
        }
        return redirect()->route('admin.vendors-payment.detail',['vendor_id'=>$vendor]);
    }
    //Destroy All Function
    public function destroyAll($vendor_id)
    {
        $payments = VendorPayment::where('vendor_id',$vendor_id)->get();
        if (!is_null($payments)) {
            //Delete the payments
            foreach($payments as $payment){
                $payment->delete();
            }
            session()->flash('success', 'vendor payment has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No vendor payment has been found !');
        }
        return redirect()->route('admin.vendors-payment.index');
    }
}
