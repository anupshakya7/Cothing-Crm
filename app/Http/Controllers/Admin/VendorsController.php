<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    public function index(Request $request)
    {


        // if (!request()->user()->hasPermissionTo('user.list')) {
        //     abort(401, 'You have not permission to list of the user !');
        // }

        $query = Vendor::query()->orderBy('name', 'ASC');
        
        //Filter by Alphabetical Letter
        if($request->filled('filter_letter')){
            $query->where('name','like',$request->input('filter_letter').'%');
        }

        // Filter by product category
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Filter by product name
        if ($request->filled('contact')) {
            $query->where('contact_number', 'like', '%' . $request->input('contact') . '%');
        }

        $vendors = $query->get();

        return view('backend.vendors.index', compact('vendors'));
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

        return view('backend.vendors.create');
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
                'address' => 'required|string',
                'contact_number' => 'required|max:255|min:8',
                'status' => 'required|string',
            ],

        );
        // If validated, insert data
        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->address = $request->address;
        $vendor->contact_number = $request->contact_number;
        $vendor->status = $request->status;
        $vendor->save();

        session()->flash('success', 'Vendor has been created !');
        return redirect()->route('admin.vendors.index');
    }

    public function edit($id)
    {

        $vendor = Vendor::find($id);
        if (!is_null($vendor)) {
            return view('backend.vendors.edit', compact('vendor'));
        }

        session()->flash('error', 'Sorry ! No User has been found !');
        return redirect()->route('admin.vendors.index');
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


        $vendor = Vendor::find($id);

        if (!is_null($vendor)) {
            // Validate our data
            $request->validate(
                [
                    'name' => 'required|string|max:255|min:2',
                    'address' => 'required|string',
                    'contact_number' => 'required|max:255|min:8',
                    'status' => 'required|string',
                ],

            );

            // If validated, insert data
            $vendor->name = $request->name;
            $vendor->address = $request->address;
            $vendor->contact_number = $request->contact_number;
            $vendor->status = $request->status;
            $vendor->save();


            session()->flash('success', 'Vendor has been updated !');
        } else {
            session()->flash('error', 'Sorry ! No Vendor has been found !');
        }
        return redirect()->route('admin.vendors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $vendor = Vendor::find($id);
        if (!is_null($vendor)) {
            // First Delete User Image & then Delete the user
            $vendor->delete();
            session()->flash('success', 'vendor has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No vendor has been found !');
        }
        return redirect()->route('admin.vendors.index');
    }
}
