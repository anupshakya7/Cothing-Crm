<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeliveryPartner;
use App\Models\Enquiry;
use App\Models\FollowUpDate;
use App\Models\Measurement;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Trailer;
use App\Models\User;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        // Start with base query
        $query = Enquiry::query()->orderBy('id', 'DESC');
        $handle_bys = User::orderBy('id', 'DESC')->get();



        // Filter by product name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Filter by contact number
        if ($request->filled('contact_number')) {
            $query->where('mobile', 'like', '%' . $request->input('contact_number') . '%');
        }

        // Filter by source
        if ($request->filled('source')) {
            $query->where('source_type',  $request->input('source'));
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority',  $request->input('priority'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status',  $request->input('status'));
        }

        // Filter by handle by
        if ($request->filled('handle_by')) {
            $query->where('handled_by', $request->input('handle_by'));
        }

        // Execute the query
        $enquirys  = $query->get();

        // Pass the filtered results to the view
        return view('backend.enquiry.index', compact('enquirys', 'handle_bys'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $handle_bys = User::orderBy('id', 'DESC')->get();

        // Check if logged in user has "user.create" permission or not
        // if (!request()->user()->hasPermissionTo('user.create')) {
        //     abort(401, 'You have not permission to create a user !');
        // }

        return view('backend.enquiry.create', compact('handle_bys'));
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
                'name' => 'required|string|max:255|min:2',
                'contact_number' => 'required|integer|unique:enquiries,mobile',
                'source_type' => 'required|string',
                'priority' => 'required|string',
                'handled_by' => 'required|string',
                'status' => 'required|string',

            ],

        );


        // If validated, insert data
        $pattern = new Enquiry();
        $pattern->name = $request->name;
        $pattern->mobile = $request->contact_number;
        $pattern->source_type = $request->source_type;
        $pattern->source = $request->source;
        $pattern->handled_by = $request->handled_by; // Save the image name in the database
        $pattern->status = $request->status;
        $pattern->priority = $request->priority;
        $pattern->remarks = $request->remarks;

        $pattern->save();
        if ($request->followup_date) {
            foreach ($request->followup_date as $key => $date) {
                $followUpDate = new FollowUpDate();
                $followUpDate->enquiry_id = $pattern->id;
                $followUpDate->follow_up_date = $date;
                $followUpDate->remarks = $request->followup_remarks[$key]; // assuming followup_remarks is an array
                $followUpDate->save();
            }
        }

        session()->flash('success', 'Enquiry has been created !');
        return redirect()->route('admin.enquiry.index');
    }

    public function edit($id)
    {

        $enquiry = Enquiry::find($id);
        $handle_bys = User::orderBy('id', 'DESC')->get();

        if (!is_null($enquiry)) {
            return view('backend.enquiry.edit', compact('enquiry', 'handle_bys'));
        }

        session()->flash('error', 'Sorry ! No enquiry has been found !');
        return redirect()->route('admin.enquiry.index');
    }

    public function followup($id)
    {

        $enquiry = Enquiry::find($id);

        if (!is_null($enquiry)) {
            return view('backend.enquiry.followup', compact('enquiry'));
        }

        session()->flash('error', 'Sorry ! No enquiry has been found !');
        return redirect()->route('admin.enquiry.index');
    }


    public function customer($id)
    {

        $enquiry = Enquiry::find($id);

        if (!is_null($enquiry)) {
            $products = Products::where('status', 'Active')->get();
            $trailers = Trailer::where('status', 'Active')->get();
            $delivery_partners = DeliveryPartner::get();
            $measurements = Measurement::where('status', 'Active')->get();
            return view('backend.enquiry.order', compact('enquiry','products','trailers','delivery_partners','measurements'));

        }

        session()->flash('error', 'Sorry ! No enquiry has been found !');
        return redirect()->route('admin.enquiry.index');

    }

    public function orderstore(Request $request)
    {


        // if (!request()->user()->hasPermissionTo('user.create')) {
        //     abort(401, 'You have not permission to create a user !');
        // }

        // Validate our data
        $request->validate(
            [
                'customer_name' => 'required|string|max:255|min:2',
                'customer_number' => 'required|numeric',
                'order_date' => 'required|string',
                'delivery_address' => 'required|string',
                'product' => 'required|integer',
                'measurement' => 'required|integer',
                'quantity' => 'required|numeric',
                'status' => 'required|string',
                'priority' => 'required|string',
                'product_handled_by' => 'required|integer',

            ],

        );
        $customer = Customer::where('customer_contact_number', $request->customer_number)->first();
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
        $vendor->customer_contact_number = $request->customer_number;
        $vendor->delivery_remarks = $request->delivery_remarks;
        $vendor->delivery_address = $request->delivery_address;
        $vendor->product_id = $request->product;
        $vendor->measurement_id = $request->measurement;
        $product = Products::findOrFail($request->product);
        $vendor->quantity = $request->quantity;
        $vendor->price = $product->price;
        $vendor->order_id = $request->quantity;
        $vendor->order_notes = $request->order_notes;
        $vendor->handled_by = $request->product_handled_by;
        $vendor->status = $request->status;
        $vendor->priority = $request->priority;
        $vendor->advance = $request->advance;
        $vendor->payment_method = $request->payment_method;
        $vendor->payment_status = $request->payment_status;
        $vendor->payment_date = $request->payment_date;
        $vendor->delivery_partner_id = $request->delivery_partner;
        $vendor->delivery_date = $request->delivery_date;
        $vendor->delivery_charge = $request->delivery_charge;
        $vendor->save();

        session()->flash('success', 'Order has been created !');
        return redirect()->route('admin.order.index');
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
        // Validate the request data
        $request->validate(
            [
                'name' => 'required|string|max:255|min:2',
                'contact_number' => 'required|integer|unique:enquiries,mobile,' . $id,
                'source_type' => 'required|string',
                'priority' => 'required|string',
                'handled_by' => 'required|string',
                'status' => 'required|string',

            ],

        );

        // Find the pattern by ID
        $pattern = Enquiry::findOrFail($id);


        $pattern->name = $request->name;
        $pattern->mobile = $request->contact_number;
        $pattern->source_type = $request->source_type;
        $pattern->source = $request->source;
        $pattern->handled_by = $request->handled_by; // Save the image name in the database
        $pattern->status = $request->status;
        $pattern->priority = $request->priority;
        $pattern->remarks = $request->remarks;
        $pattern->save();
        FollowUpDate::where('enquiry_id', $pattern->id)->delete();

        if ($request->followup_date) {
            foreach ($request->followup_date as $key => $date) {
                $followUpDate = new FollowUpDate();
                $followUpDate->enquiry_id = $pattern->id;
                $followUpDate->follow_up_date = $date;
                $followUpDate->remarks = $request->followup_remarks[$key]; // assuming followup_remarks is an array
                $followUpDate->save();
            }
        }
        // Flash success message and redirect
        session()->flash('success', 'enquiry has been updated!');
        return redirect()->route('admin.enquiry.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pattern = Enquiry::find($id);

        if (!is_null($pattern)) {

            // Delete the pattern
            $pattern->delete();
            session()->flash('success', 'Enquiry has been deleted!');
        } else {
            session()->flash('error', 'Sorry! No Enquiry found!');
        }

        return redirect()->route('admin.enquiry.index');
    }
}
