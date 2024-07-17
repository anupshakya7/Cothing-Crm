<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Page;
use Image;
use URL;
use File;
use App\Http\Requests\StoreProductsRequest;
use App\Models\Category;
use App\Models\Measurement;
use App\Models\Pattern;
use App\Models\Products;

class ProductsController extends Controller
{


    public function index(Request $request)
    {
        $query = Products::query()->orderBy('id', 'DESC');

        // Filter by product category
        if ($request->filled('product_category')) {
            $query->where('category_id', $request->input('product_category'));
        }

        // Filter by product name
        if ($request->filled('product_name')) {
            $query->where('name', 'like', '%' . $request->input('product_name') . '%');
        }

        // Filter by pattern
        if ($request->filled('pattern')) {
            $query->where('pattern_id', $request->input('pattern'));
        }

        // Filter by measurement
        if ($request->filled('measurement')) {
            $query->where('measurement_id', $request->input('measurement'));
        }

        $products = $query->get();
        $patterns = Pattern::where('status', 'Active')->get();
        $measurements = Measurement::where('status', 'Active')->get();
        $categorys = Category::where('status', 'Active')->where('category_type',1)->get();


        return view('backend.product.index', compact('products', 'patterns', 'measurements', 'categorys'));
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
        $catgeory_id = isset($_REQUEST['product_category']) ? $_REQUEST['product_category'] : '';

        $patterns = Pattern::where('status', 'Active')->get();
        $measurements = Measurement::where('status', 'Active')->get();
        $categorys = Category::where('status', 'Active')->where('category_type',1)->get();

        return view('backend.product.create', compact("patterns", "measurements", "categorys","catgeory_id"));
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
                'pattern' => 'required|integer',
                'category' => 'required|integer',
                // 'measurement' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Make the image field nullable
                'price' => 'required|numeric',
                'status' => 'required|string',

            ],

        );
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Check if directory exists, if not, create it with appropriate permissions
            $directory = public_path('images/product');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Move the image to the directory
            $image->move($directory, $imageName);
        } else {
            $imageName = null; // Set image name to null if not provided
        }
        // If validated, insert data
        $pattern = new Products();
        $pattern->name = $request->name;
        $pattern->status = $request->status;
        $pattern->pattern_id = $request->pattern;
        $pattern->category_id = $request->category;
        $pattern->image = $imageName; // Save the image name in the database
        $pattern->measurement_id = $request->measurement;
        $pattern->price = $request->price;
        $pattern->description = $request->description;

        $pattern->save();

        session()->flash('success', 'pattern has been created !');
        return redirect()->route('admin.product.index');
    }

    public function edit($id)
    {

        $product = Products::find($id);
        $patterns = Pattern::where('status', 'Active')->get();
        $measurements = Measurement::where('status', 'Active')->get();
        $categorys = Category::where('status', 'Active')->where('category_type',1)->get();
        if (!is_null($product)) {
            return view('backend.product.edit', compact('product',"patterns", "measurements", "categorys"));
        }

        session()->flash('error', 'Sorry ! No product has been found !');
        return redirect()->route('admin.product.index');
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
                'pattern' => 'required|integer',
                'category' => 'required|integer',
                // 'measurement' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Make the image field nullable
                'price' => 'required|numeric',
                'status' => 'required|string',

            ],

        );

        // Find the pattern by ID
        $pattern = Products::findOrFail($id);


        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Check if directory exists, if not, create it with appropriate permissions
            $directory = public_path('images/product');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Move the new image to the directory
            $image->move($directory, $imageName);

            // Delete the old image if exists
            if ($pattern->image) {
                $oldImagePath = public_path('images/product/' . $pattern->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Update the image name in the database
            $pattern->image = $imageName;
        }

        // Update other fields
        $pattern->name = $request->name;
        $pattern->status = $request->status;
        $pattern->pattern_id = $request->pattern;
        $pattern->category_id = $request->category;
        $pattern->measurement_id = $request->measurement;
        $pattern->price = $request->price;
        $pattern->description = $request->description;
        $pattern->save();

        // Flash success message and redirect
        session()->flash('success', 'product has been updated!');
        return redirect()->route('admin.product.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pattern = Products::find($id);

        if (!is_null($pattern)) {
            // Check if the pattern has an associated image
            if (!is_null($pattern->image)) {
                // Delete the pattern's image file
                $imagePath = public_path('images/product/' . $pattern->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Delete the pattern
            $pattern->delete();
            session()->flash('success', 'product has been deleted!');
        } else {
            session()->flash('error', 'Sorry! No product found!');
        }

        return redirect()->route('admin.product.index');
    }
}
