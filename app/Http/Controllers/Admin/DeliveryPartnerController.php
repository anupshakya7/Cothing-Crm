<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryPartner;
use Illuminate\Http\Request;

class DeliveryPartnerController extends Controller
{
    public function index()
    {


        // if (!request()->user()->hasPermissionTo('user.list')) {
        //     abort(401, 'You have not permission to list of the user !');
        // }

        $customers = DeliveryPartner::orderBy('id','desc')->get();
        return view('backend.delivery.index', compact('customers'));
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

        return view('backend.delivery.create');
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
                'contact_number' => 'required|integer|unique:delivery_partners,contact_number',
                'address' => 'required|string',

            ],

        );
        // If validated, insert data
        $item = new DeliveryPartner();
        $item->delivery_company_name = $request->name;
        $item->contact_number = $request->contact_number;
        $item->address = $request->address;
        $item->save();

        session()->flash('success', 'DeliveryPartner has been created !');
        return redirect()->route('admin.delivery.index');
    }

    public function edit($id)
    {

        $item = DeliveryPartner::find($id);
        if (!is_null($item)) {
            return view('backend.delivery.edit', compact('item'));
        }

        session()->flash('error', 'Sorry ! No DeliveryPartner has been found !');
        return redirect()->route('admin.delivery.index');
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


        $item = DeliveryPartner::find($id);

        if (!is_null($item)) {
            // Validate our data
            $request->validate(
                [
                    'name' => 'required|string|max:255|min:2',
                    'contact_number' => 'required|integer|unique:delivery_partners,contact_number,'.$id,
                    'address' => 'required|string',

                ],

            );
            // If validated, insert data
            $item->delivery_company_name = $request->name;
            $item->contact_number = $request->contact_number;
            $item->address = $request->address;
            $item->save();


            session()->flash('success', 'DeliveryPartner has been updated !');
        } else {
            session()->flash('error', 'Sorry ! No DeliveryPartner has been found !');
        }
        return redirect()->route('admin.delivery.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $item = DeliveryPartner::find($id);
        if (!is_null($item)) {
            // First Delete User Image & then Delete the user
            $item->delete();
            session()->flash('success', 'DeliveryPartner has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No DeliveryPartner has been found !');
        }
        return redirect()->route('admin.delivery.index');
    }
}
