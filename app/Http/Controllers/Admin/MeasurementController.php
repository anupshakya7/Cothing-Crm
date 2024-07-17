<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function index(Request $request)
    {


        // if (!request()->user()->hasPermissionTo('user.list')) {
        //     abort(401, 'You have not permission to list of the user !');
        // }

        // Fetch all measurements
        $measurementsQuery = Measurement::query();

        // Check if search parameters are present in the request
        if ($request->filled('category')) {
            $measurementsQuery->where('category', $request->input('category'));
        }

        if ($request->filled('size')) {
            $measurementsQuery->where('size', 'like', '%' . $request->input('size') . '%');
        }

        if ($request->filled('status')) {
            $measurementsQuery->where('status', $request->input('status'));
        }

        // Get filtered measurements
        $measurements = $measurementsQuery->orderBy('id','desc')->get();
        return view('backend.measurement.index', compact('measurements'));
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

        return view('backend.measurement.create');
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
                'category' => 'required|string|max:255|min:2',
                'size' => 'required|string',
            ],

        );
        // If validated, insert data
        $measurement = new Measurement();
        $measurement->category = $request->category;
        $measurement->size = $request->size;
        $measurement->description = $request->remarks;
        $measurement->status = $request->status;
        $measurement->top = $request->top;
        $measurement->bottom = $request->bottom;
        $measurement->save();

        session()->flash('success', 'measurement has been created !');
        return redirect()->route('admin.measurement.index');
    }

    public function edit($id)
    {

        $measurement = Measurement::find($id);
        if (!is_null($measurement)) {
            return view('backend.measurement.edit', compact('measurement'));
        }

        session()->flash('error', 'Sorry ! No measurement has been found !');
        return redirect()->route('admin.measurement.index');
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


        $measurement = Measurement::find($id);

        if (!is_null($measurement)) {
            // Validate our data
            $request->validate(
                [
                    'category' => 'required|string|max:255|min:2',
                    'size' => 'required|string',
                ],

            );

            // If validated, insert data
            $measurement->category = $request->category;
            $measurement->size = $request->size;
            $measurement->description = $request->remarks;
            $measurement->status = $request->status;
            $measurement->top = $request->top;
            $measurement->bottom = $request->bottom;
            $measurement->save();

            session()->flash('success', 'measurement has been updated !');
        } else {
            session()->flash('error', 'Sorry ! No measurement has been found !');
        }
        return redirect()->route('admin.measurement.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $measurement = Measurement::find($id);
        if (!is_null($measurement)) {
            // First Delete User Image & then Delete the user
            $measurement->delete();
            session()->flash('success', 'measurement has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No measurement has been found !');
        }
        return redirect()->route('admin.measurement.index');
    }
}
