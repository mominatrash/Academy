<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_admins(Request $request)
    {
        $data = Admin::orderBy('id', 'DESC')->paginate(5);
        return view('admins.show_admins', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_user()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admins.Add_user', compact('roles'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_user(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            // 'roles_name' => 'required'
        ]);

        $input = $request->all();


        $input['password'] = Hash::make($input['password']);

        $input['roles_name'] = json_encode($input['roles_name']);
        $user = Admin::create($input);


        // foreach($request->input('roles_name') as $role){
            $user->assignRole($request->input('roles_name'));
        // }

        return redirect()->route('show_admins')
            ->with('success', 'تم اضافة المستخدم بنجاح');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Admin::find($id);
        return view('admins.show', compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_user($id)
    {
        $user = Admin::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('admins.edit', compact('user', 'roles', 'userRole'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_user(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $request->id,
            'password' => 'same:confirm-password',
            //'roles_name' => 'required'
        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }
        $user = Admin::find($request->id);
        
        $input = request()->except('confirm-password');
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $request->id)->delete();
        $user->assignRole($request->input('roles_name'));
        return redirect()->route('show_admins')
            ->with('success', 'User updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user_delete(Request $request)
    {
 
        Admin::find($request->user_id)->delete();
        return redirect()->route('show_admins')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
}
