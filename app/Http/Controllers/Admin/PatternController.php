<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use App\Models\Pattern;
use Illuminate\Http\Request;

class PatternController extends Controller
{
    public function index(Request $request)
    {


        // if (!request()->user()->hasPermissionTo('user.list')) {
        //     abort(401, 'You have not permission to list of the user !');
        // }

        $query = Pattern::orderBy('id', 'desc');
        if ($request->filled('category')) {
            $query->where('sizecategory', $request->input('category'));
        }
        if ($request->filled('size')) {
            $query->where('size', $request->input('size'));
        }
        $patterns = $query->orderBy('id', 'desc')->get();
        $sizes = Measurement::where('status', 'Active')->orderBy('id', 'desc')->get();
        return view('backend.pattern.index', compact('patterns', 'sizes'));
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
        $sizes = Measurement::where('status', 'Active')->orderBy('id', 'desc')->get();

        return view('backend.pattern.create', compact('sizes'));
    }

    public function sizes($category)
    {
        $sizes = Measurement::where('category', $category)->where('status', 'Active')->orderBy('id', 'desc')->get();
        return response()->json($sizes);
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
                'size' => 'required',
                'status' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Make the image field nullable

            ],

        );
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Check if directory exists, if not, create it with appropriate permissions
            $directory = public_path('images/pattern');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Move the image to the directory
            $image->move($directory, $imageName);
        } else {
            $imageName = null; // Set image name to null if not provided
        }
        // If validated, insert data
        $pattern = new Pattern();
        $pattern->name = $request->name;
        $pattern->status = $request->status;
        $pattern->size = $request->size;
        $pattern->sizecategory = $request->category;
        $pattern->image = $imageName; // Save the image name in the database

        $pattern->save();

        session()->flash('success', 'pattern has been created !');
        return redirect()->route('admin.pattern.index');
    }

    public function edit($id)
    {

        $pattern = Pattern::find($id);
        if (!is_null($pattern)) {
            $sizes = Measurement::where('category', $pattern->sizecategory)->where('status', 'Active')->orderBy('id', 'desc')->get();

            return view('backend.pattern.edit', compact('pattern', 'sizes'));
        }

        session()->flash('error', 'Sorry ! No pattern has been found !');
        return redirect()->route('admin.pattern.index');
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
        $request->validate([
            'name' => 'required|string|max:255|min:2',
            'size' => 'required',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Make the image field nullable
        ]);

        // Find the pattern by ID
        $pattern = Pattern::findOrFail($id);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Check if directory exists, if not, create it with appropriate permissions
            $directory = public_path('images/pattern');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Move the new image to the directory
            $image->move($directory, $imageName);

            // Delete the old image if exists
            if ($pattern->image) {
                $oldImagePath = public_path('images/pattern/' . $pattern->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Update the image name in the database
            $pattern->image = $imageName;
        }

        // Update other fields
        $pattern->name = $request->name;
        $pattern->size = $request->size;
        $pattern->status = $request->status;
        $pattern->sizecategory = $request->category;

        $pattern->save();

        // Flash success message and redirect
        session()->flash('success', 'Pattern has been updated!');
        return redirect()->route('admin.pattern.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pattern = Pattern::find($id);

        if (!is_null($pattern)) {
            // Check if the pattern has an associated image
            if (!is_null($pattern->image)) {
                // Delete the pattern's image file
                $imagePath = public_path('images/pattern/' . $pattern->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Delete the pattern
            $pattern->delete();
            session()->flash('success', 'Pattern has been deleted!');
        } else {
            session()->flash('error', 'Sorry! No pattern found!');
        }

        return redirect()->route('admin.pattern.index');
    }
}
