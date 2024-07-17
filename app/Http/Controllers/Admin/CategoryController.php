<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 3;


        // if (!request()->user()->hasPermissionTo('user.list')) {
        //     abort(401, 'You have not permission to list of the user !');
        // }

        $query = Category::where('category_type', $type);

        if ($request->filled('category')) {
            $query->where('parent_category', $request->input('category'));
        }
        $categorys = $query->orderBy('id', 'desc')->get();
        if ($type == 1) {
            return view('backend.categorys.index', compact('categorys', 'type'));
        } else {
            if ($type == 2) {
                $maincategorys = Category::where('category_type', 1)->get();
            } else {
                $maincategorys = Category::where('category_type', 2)->get();
            }
            return view('backend.categorys.subindex', compact('categorys', 'type', 'maincategorys'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = request()->user();
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 3;
        $catgeory_id = isset($_REQUEST['category']) ? $_REQUEST['category'] : '';
        $parent_cat_id = '';
        if($catgeory_id){
            $parentcategory = Category::where('id', $catgeory_id)->first();
            $parent_cat_id = $parentcategory->parent_category;

        }

        // Check if logged in user has "user.create" permission or not
        // if (!request()->user()->hasPermissionTo('user.create')) {
        //     abort(401, 'You have not permission to create a user !');
        // }

        if ($type == 1) {
            return view('backend.categorys.create');
        } elseif ($type == 2) {
            $categorys = Category::where('category_type', 1)->get();
            return view('backend.categorys.createsub', compact('categorys','catgeory_id'));
        } else {
            $maincategorys = Category::where('category_type', 1)->get();
            $categorys = Category::where('category_type', 2)->get();
            return view('backend.categorys.createcat', compact('categorys', 'maincategorys','catgeory_id','parent_cat_id'));
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
        $request->validate([
            'name' => 'required|string|max:255|min:2',
            'status' => 'required|string',
            'category' => $request->category_type == 2 || $request->category_type == 3 ? 'required|string' : '', // Conditional validation
        ]);
        // If validated, insert data
        $item = new Category();
        $item->name = $request->name;
        $item->status = $request->status;
        $item->category_type = $request->category_type;
        if ($request->category_type == 2 || $request->category_type == 3) {
            $item->parent_category = $request->category;
        }

        $item->save();

        session()->flash('success', 'Category has been created !');
        return redirect()->route('admin.category.index', ['type' => $request->category_type]);
    }

    public function edit($id, $type)
    {

        $category = Category::find($id);
        if (!is_null($category)) {
            $categorys = Category::where('category_type', 1)->get();

            if ($type == 1) {
                return view('backend.categorys.edit', compact('category', 'type'));
            } elseif ($type == 2) {
                $categorys = Category::where('category_type', 1)->get();

                return view('backend.categorys.editsub', compact('category', 'type', 'categorys'));
            } else {
                $maincategorys = Category::where('category_type', 1)->get();
                $categorys = Category::where('category_type', 2)->get();
                $main_cat = Category::where('id', $category->parent_category)->first();
                return view('backend.categorys.editcat', compact('category', 'type', 'categorys', 'maincategorys', 'main_cat'));
            }
        }

        session()->flash('error', 'Sorry ! No User has been found !');
        return redirect()->route('admin.category.index', ['type' => $type]);
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


        $category = Category::find($id);

        if (!is_null($category)) {
            // Validate our data
            $request->validate(
                [
                    'name' => 'required|string|max:255|min:2',
                    'status' => 'required|string',
                    'category' => $request->category_type == 2 || $request->category_type == 3 ? 'required|string' : '', // Conditional validation

                ],

            );

            // If validated, insert data
            $category->name = $request->name;
            $category->status = $request->status;
            $category->category_type = $request->category_type;
            if ($request->category_type == 2 || $request->category_type == 3) {
                $category->parent_category = $request->category;
            }
            $category->save();


            session()->flash('success', 'category has been updated !');
        } else {
            session()->flash('error', 'Sorry ! No category has been found !');
        }
        return redirect()->route('admin.category.index', ['type' => $request->category_type]);
    }


    public function maincategory($category)
    {
        $categorys = Category::where('parent_category', $category)->where('category_type', 2)->where('status', 'Active')->orderBy('id', 'desc')->get();
        return response()->json($categorys);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 3;


        $category = Category::find($id);
        if (!is_null($category)) {
            // First Delete User Image & then Delete the user
            $category->delete();
            session()->flash('success', 'category has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No category has been found !');
        }
        return redirect()->route('admin.category.index', ['type' => $type]);
    }
}
