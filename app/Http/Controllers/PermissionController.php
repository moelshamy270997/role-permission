<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('admin')) {
            return view('roles_permissions/dashboard-permission')->with(['permissions' => Permission::all()]);
        }

        $permissions = Permission::withTrashed()->get();
        return view('roles_permissions/dashboard-permission')->with(['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('admin')) {
            $roles = Role::all();
            return view('roles_permissions/create-permission')->with(['roles' => $roles]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'guard_name' => 'required|max:255',
            'role' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->only(['name', 'guard_name']));
        }

        $permission = new Permission;

        $permission->name = $request->get('name');
        $permission->guard_name = $request->get('guard_name');
        $permission->save();

        $role = Role::where('name', $request->get('role'))->get();

        $permission->roles()->attach($role);

        return redirect()->route('permission.index')->with(['success-created' => 'permission created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);
        return view('roles_permissions/show-permission')->with(['permission' => $permission]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::authorize('admin')) {
            $permission = Permission::findOrFail($id);
            $roles = Role::all();
            return view('roles_permissions/edit-permission')->with(['permission' => $permission, 'roles' => $roles]);
        }
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'guard_name' => 'required|max:255',
            'role' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->only(['name', 'guard_name']));
        }

        $permission = Permission::findOrFail($id);

        $permission->name = $request->get('name');
        $permission->guard_name = $request->get('guard_name');
        $permission->updated_at = now();
        $permission->save();

        $role = Role::where('name', $request->get('role'))->get();
        $permission->roles()->attach($role);

        return redirect()->route('permission.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permission.index')->with(['success-deleted' => 'the permission has been deleted successfully']);
    }

    public function restore(Request $request)
    {
        $permission = Permission::onlyTrashed()->findOrFail($request->get('id'));
        $permission->restore();

        return redirect()->route('permission.index')->with(['success-restored' => 'the permission has been restored successfully']);
    }
}
