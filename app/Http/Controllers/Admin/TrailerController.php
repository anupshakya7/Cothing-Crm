<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trailer;
use Illuminate\Http\Request;

class TrailerController extends Controller
{
    public function index(Request $request)
    {


        // if (!request()->user()->hasPermissionTo('user.list')) {
        //     abort(401, 'You have not permission to list of the user !');
        // }

        $query = Trailer::query()->orderBy('id', 'DESC');

        // Filter by product category
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Filter by product name
        if ($request->filled('contact')) {
            $query->where('contact_number', 'like', '%' . $request->input('contact') . '%');
        }

        $vendors = $query->get();

        return view('backend.trailer.index', compact('vendors'));
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

        return view('backend.trailer.create');
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
                'contact_number' => 'required|max:255||max:15|min:8',
                'status' => 'required|string',
            ],

        );
        // If validated, insert data
        $vendor = new Trailer();
        $vendor->name = $request->name;
        $vendor->address = $request->address;
        $vendor->contact_number = $request->contact_number;
        $vendor->status = $request->status;
        $vendor->save();

        session()->flash('success', 'trailer has been created !');
        return redirect()->route('admin.trailer.index');
    }

    public function edit($id)
    {

        $vendor = Trailer::find($id);
        if (!is_null($vendor)) {
            return view('backend.trailer.edit', compact('vendor'));
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


        $vendor = Trailer::find($id);

        if (!is_null($vendor)) {
            // Validate our data
            $request->validate(
                [
                    'name' => 'required|string|max:255|min:2',
                    'address' => 'required|string',
                    'contact_number' => 'required|max:255||max:15|min:8',
                    'status' => 'required|string',
                ],

            );

            // If validated, insert data
            $vendor->name = $request->name;
            $vendor->address = $request->address;
            $vendor->contact_number = $request->contact_number;
            $vendor->status = $request->status;
            $vendor->save();


            session()->flash('success', 'trailer has been updated !');
        } else {
            session()->flash('error', 'Sorry ! No trailer has been found !');
        }
        return redirect()->route('admin.trailer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $vendor = Trailer::find($id);
        if (!is_null($vendor)) {
            // First Delete User Image & then Delete the user
            $vendor->delete();
            session()->flash('success', 'trailer has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No trailer has been found !');
        }
        return redirect()->route('admin.trailer.index');
    }
}
