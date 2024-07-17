<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SupplyCategoryItem;
use App\Models\SupplyItems;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index(Request $request)
    {
        // if (!request()->user()->hasPermissionTo('user.list')) {
        //     abort(401, 'You have not permission to list of the user !');
        // }

        $query = SupplyItems::with('category');

        if($request->filled('category')){
            $query->where('supply_category_id',$request->input('category'));
        }
        
        $items = $query->orderBy('id','desc')->get();

        return view('backend.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = request()->user();
        $category_id = isset($_REQUEST['category']) ? $_REQUEST['category'] : '';

        $categories = SupplyCategoryItem::where('category_type',2)->where('status','active')->get();

        // Check if logged in user has "user.create" permission or not
        // if (!request()->user()->hasPermissionTo('user.create')) {
        //     abort(401, 'You have not permission to create a user !');
        // }

        return view('backend.items.create',compact('categories','category_id'));
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
                'image'=> 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category'=>'required',
                'status' => 'required|string',
            ],

        );

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            //Check if directory exists, if not, create it with appropriate permissions
            $directory = public_path('images/supplyItem');
            if(!file_exists($directory)){
                mkdir($directory,0777,true);
            }

            //Move the image to the directory
            $image->move($directory,$imageName);
        }else{
            $imageName = null; //Set image name to null if not provided
        }

        // If validated, insert data
        $item = new SupplyItems();
        $item->name = $request->name;
        $item->image = $imageName;
        $item->supply_category_id = $request->category;
        $item->status = $request->status;
        $item->save();

        session()->flash('success', 'SupplyItems has been created !');
        return redirect()->route('admin.items.index');
    }

    public function edit($id)
    {

        $item = SupplyItems::with('category')->find($id);
        if (!is_null($item)) {
            $categories = SupplyCategoryItem::where('category_type',2)->where('status','active')->get();
            return view('backend.items.edit', compact('item','categories'));
        }

        session()->flash('error', 'Sorry ! No User has been found !');
        return redirect()->route('admin.items.index');
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
        $item = SupplyItems::find($id);

        if (!is_null($item)) {
            // Validate our data
            $request->validate(
                [
                    'name' => 'required|string|max:255|min:2',
                    'image'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'category'=>'required',
                    'status' => 'required|string',
                ],

            );

            //Handle image upload if provided
            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();

                //Check if directory exists, if not, create it with appropriate permissions
                $directory = public_path('images/supplyItem');
                if(!file_exists($directory)){
                    mkdir($directory,0777,true);
                }

                //Move the new image to the directory
                $image->move($directory,$imageName);

                //Delete the old image if exists
                if($item->image){
                    $oldImagePath = public_path('images/supplyItem/'.$item->image);
                    if(file_exists($oldImagePath)){
                        unlink($oldImagePath);
                    }
                }

                $item->image = $imageName;
            }

            // If validated, insert data
            $item->name = $request->name;
            $item->supply_category_id = $request->category;
            $item->status = $request->status;
            $item->save();


            session()->flash('success', 'SupplyItems has been updated !');
        } else {
            session()->flash('error', 'Sorry ! No SupplyItems has been found !');
        }
        return redirect()->route('admin.items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $item = SupplyItems::find($id);
        if (!is_null($item)) {
            if(!is_null($item->image)){
                // First Delete User Image
                $imagePath = public_path('images/supplyItem/'.$item->image);
                if(file_exists($imagePath)){
                    unlink($imagePath);
                }
            }
            //Then Delete the user
            $item->delete();
            session()->flash('success', 'item has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No vendor has been found !');
        }
        return redirect()->route('admin.items.index');
    }
}
