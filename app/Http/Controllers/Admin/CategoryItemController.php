<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SupplyCategoryItem;
use Illuminate\Http\Request;

class CategoryItemController extends Controller
{
    public function index()
    {
        $type = isset($_REQUEST['type']) ? $_REQUEST['type']:'';

        // if (!request()->user()->hasPermissionTo('user.list')) {
        //     abort(401, 'You have not permission to list of the user !');
        // }


        $query = SupplyCategoryItem::with('parentCategory')->where('category_type',$type);

        if(isset($_REQUEST['category'])){
            $query->where('parent_category',$_REQUEST['category']);
        }

        $categories = $query->where('status','Active')->orderBy('id','desc')->get();
        
        return view('backend.suppliers.category.index', compact('categories','type'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = request()->user();
        $type = isset($_REQUEST['type']) ? $_REQUEST['type']:'';
        // Check if logged in user has "user.create" permission or not
        // if (!request()->user()->hasPermissionTo('user.create')) {
        //     abort(401, 'You have not permission to create a user !');
        // }
        
        if($type == 2){
            $categories = SupplyCategoryItem::where('category_type',1)->where('status','active')->get();
            return view('backend.suppliers.category.create',compact('type','categories'));
        }else{
            return view('backend.suppliers.category.create',compact('type'));
        }
        

        
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
                'status' => 'required|string',
            ],
        );
        if($request->type == 2){
            $request->validate([
                'category'=>'required'
            ]);
        }

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            //Check if directory exists, if not, create it with appropriate permissions
            $directory = $request->type == 1 ? public_path('images/supplyCategory'):public_path('images/supplySubCategory');

            if(!file_exists($directory)){
                mkdir($directory,0777,true);
            }

            //Move the image to the directory
            $image->move($directory,$imageName);
        }else{
            $imageName = null; //Set image name to null if not provided
        }

        // If validated, insert data
        $item = new SupplyCategoryItem();
        $item->name = $request->name;
        $item->image = $imageName;
        $item->status = $request->status;
        $item->category_type = $request->type;
        if($request->type == 2){
            $item->parent_category = $request->category;
        }
        $item->save();

        session()->flash('success', 'Supply Category has been created !');
        return redirect()->route('admin.items-category.index',['type'=>$request->type]);
    }

    public function edit($id,$type)
    {
        $category = SupplyCategoryItem::find($id);
        if (!is_null($category)) {
            if($type ==1){
                return view('backend.suppliers.category.edit', compact('category','type'));
            }elseif($type == 2){
                $categories = SupplyCategoryItem::where('category_type',1)->where('status','active')->get();
                return view('backend.suppliers.category.edit', compact('category','categories','type'));
            }   
        }

        session()->flash('error', 'Sorry ! No Category has been found !');
        return redirect()->route('admin.items-category.index',['type'=> $type]);
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
        $category = SupplyCategoryItem::find($id);

        if (!is_null($category)) {
            // Validate our data
            $request->validate(
                [
                    'name' => 'required|string|max:255|min:2',
                    'image'=> 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'status' => 'required|string',
                ],

            );
            if($request->type == 2){
                $request->validate([
                    'category'=>'required'
                ]);
            }

            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();

                //Check if directory exists, if not, create it with appropriate permissions
                $directory = $request->type == 1 ? public_path('images/supplyCategory'):public_path('images/supplySubCategory');
                if(!file_exists($directory)){
                    mkdir($directory,0777,true);
                }

                //Move the image to the directory
                $image->move($directory,$imageName);

                //Delete the old image if exists
                if($category->image){
                    $oldImagePath = $request->type == 1 ? public_path('images/supplyCategory/'.$category->image) : public_path('images/supplySubCategory/'.$category->image);
                    if(file_exists($oldImagePath)){
                        unlink($oldImagePath);
                    }
                }
            }else{
                $imageName = null; //Set image name to null if not provided
            }

            // If validated, insert data
            $category->name = $request->name;
            $category->image = $imageName;
            $category->status = $request->status;
            $category->category_type = $request->type;
            if($request->type == 2){
                $category->parent_category = $request->category;
            }
            $category->save();


            session()->flash('success', 'Supply Category has been updated !');
        } else {
            session()->flash('error', 'Sorry ! No Supply Category has been found !');
        }
        return redirect()->route('admin.items-category.index',['type'=>$request->type]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$type)
    {
        $item = SupplyCategoryItem::find($id);
        if (!is_null($item)) {
            if(!is_null($item->image)){
                //First Delete User Image
                $imagePath = $type == 1 ? public_path('images/supplyCategory/'.$item->image):public_path('images/supplySubCategory/'.$item->image);
                if(file_exists($imagePath)){
                    unlink($imagePath);
                }
            }

            if($type == 1){
                $supplySubCategories = SupplyCategoryItem::where('parent_category',$id)->get();
                foreach($supplySubCategories as $supplySubCategory){
                    if(!is_null($supplySubCategory->image)){
                        //Delete Sub Category Image If there is any
                        $imagePath = public_path('images/supplySubCategory/'.$supplySubCategory->image);
                        if(file_exists($imagePath)){
                            unlink($imagePath);
                        }
                        $supplySubCategory->delete();
                    }
                }
            }

            //Then Delete the user
            $item->delete();
            session()->flash('success', 'category has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No category has been found !');
        }
        return redirect()->route('admin.items-category.index',['type'=>$type]);
    }
}
