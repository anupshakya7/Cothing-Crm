<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {


        // if (!request()->user()->hasPermissionTo('user.list')) {
        //     abort(401, 'You have not permission to list of the user !');
        // }
        $query =  Customer::orderBy('customer_name', 'asc');

        if ($request->filled('filter_letter')) {
            $query->where('customer_name', 'like', $request->input('filter_letter') . '%');
        }

        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->input('customer_name') . '%');
        }

        if ($request->filled('customer_contact_number')) {
            $query->where('customer_contact_number', $request->input('customer_contact_number'));
        }


        $customers =  $query->withCount('orders')->withSum('orders', 'total_price')->paginate(50);
        return view('backend.customer.index', compact('customers'));
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

        return view('backend.customer.create');
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
                'contact_number' => 'nullable|integer|unique:customers,customer_contact_number',
                'address' => 'required|string',
                'email' => 'nullable|string|email|unique:customers,email',

            ],

        );
        // If validated, insert data
        $item = new Customer();
        $item->customer_name = $request->name;
        $item->customer_contact_number = $request->contact_number;
        $item->address = $request->address;
        $item->email = $request->email;
        $item->source = "Manual";
        $item->save();

        session()->flash('success', 'Customer has been created !');
        return redirect()->route('admin.customer.index');
    }

    public function edit($id)
    {

        $item = Customer::find($id);
        if (!is_null($item)) {
            return view('backend.customer.edit', compact('item'));
        }

        session()->flash('error', 'Sorry ! No Customer has been found !');
        return redirect()->route('admin.customer.index');
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


        $item = Customer::find($id);

        if (!is_null($item)) {
            // Validate our data
            $request->validate(
                [
                    'name' => 'required|string|max:255|min:2',
                    'contact_number' => 'nullable|integer|unique:customers,customer_contact_number,' . $id,
                    'address' => 'required|string',
                    'email' => 'nullable|string|email|unique:customers,email,' . $id,

                ],

            );
            // If validated, insert data
            $item->customer_name = $request->name;
            $item->customer_contact_number = $request->contact_number;
            $item->address = $request->address;
            $item->email = $request->email;
            $item->save();


            session()->flash('success', 'Customer has been updated !');
        } else {
            session()->flash('error', 'Sorry ! No Customer has been found !');
        }
        return redirect()->route('admin.customer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $item = Customer::find($id);
        if (!is_null($item)) {
            // First Delete User Image & then Delete the user
            $item->delete();
            session()->flash('success', 'Customer has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No Customer has been found !');
        }
        return redirect()->route('admin.customer.index');
    }
}
