<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        // if (!request()->user()->hasPermissionTo('user.list')) {
        //     abort(401, 'You have not permission to list of the user !');
        // }

        $users = User::all();
        return view('backend.users.index', compact('users'));
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

        return view('backend.users.create');
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
                'email' => 'required|string|email|max:255|unique:users',
                'phone_no' => 'required|max:255|unique:users|max:15|min:8',
                'image' => 'nullable|image|max:2048',
                'status' => 'required|string',
            ],
            [
                'name.required' => 'Please, give your name !',
                'email.required' => 'Please, give your email !',
                'phone_no.required' => 'Please, give your phone no !',
                'email.unique' => 'Sorry, This email already exists. Please, give another email !',
                'phone_no.unique' => 'Sorry, This phone no already exists. Please, give another phone no !',
                'image.image' => "Please give a valid profile image !!",
            ]
        );
        // If validated, insert data
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone_no = $request->phone_no;
        $user->status = $request->status;
        $user->created_by = request()->user()->id;
        $user->save();

        if ($request->image) {
            $imageName = UploadHelper::upload($request->image, 'user-' . $user->id, 'images/users');
            $user->image = $imageName;
            $user->save();
        }

        session()->flash('success', 'User has been created !');
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // if (!request()->user()->hasPermissionTo('user.view')) {
        //     abort(401, 'You have not permission to view a user !');
        // }

        //
    }

    public function profile()
    {


        return view('backend.users.profile');

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if (!request()->user()->hasPermissionTo('user.edit')) {
        //     abort(401, 'You have not permission to edit a user !');
        // }

        $user = User::find($id);
        if (!is_null($user)) {
            return view('backend.users.edit', compact('user'));
        }

        session()->flash('error', 'Sorry ! No User has been found !');
        return redirect()->route('admin.users.index');
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
        // if (!request()->user()->hasPermissionTo('user.edit')) {
        //     abort(401, 'You have not permission to update a user !');
        // }

        $user = User::find($id);

        if (!is_null($user)) {
            // Validate our data
            $request->validate(
                [
                    'name' => 'required|string|max:255|min:2',
                    'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                    'phone_no' => 'required|max:255|max:15|min:8|unique:users,phone_no,' . $user->id,
                    'status' => 'required|string',
                ],
                [
                    'name.required' => 'Please, give your name !',
                    'email.required' => 'Please, give your email !',
                    'phone_no.required' => 'Please, give your phone no !',
                    'email.unique' => 'Sorry, This email already exists. Please, give another email !',
                    'phone_no.unique' => 'Sorry, This phone no already exists. Please, give another phone no !',
                    'image.image' => "Please give a valid profile image !!",
                ]
            );

            // If validated, insert data
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_no = $request->phone_no;
            $user->status = $request->status;
            $user->updated_by = request()->user()->id;
            $user->updated_at = date('Y-m-d H:i:s');

            $user->save();

            if ($request->image) {
                // Delete the previous image stored & Upload this image
                $imageName = UploadHelper::update($request->image, 'user-' . $user->id, 'images/users', $user->image);

                $user->image = $imageName;
                $user->save();
            }

            session()->flash('success', 'User has been updated !');
        } else {
            session()->flash('error', 'Sorry ! No User has been found !');
        }
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!request()->user()->hasPermissionTo('user.delete')) {
            abort(401, 'You have not permission to delete a user !');
        }

        $user = User::find($id);
        if (!is_null($user)) {
            // First Delete User Image & then Delete the user
            UploadHelper::delete('images/users/' . $user->image);
            $user->deleted_by = request()->user()->id;
            $user->delete();
            session()->flash('success', 'User has been deleted !');
        } else {
            session()->flash('error', 'Sorry ! No User has been found !');
        }
        return redirect()->route('admin.users.index');
    }
}
