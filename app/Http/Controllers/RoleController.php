<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
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
            return view('roles_permissions/dashboard-role')->with(['roles' => Role::all()]);
        }

        $roles = Role::withTrashed()->get();
        return view('roles_permissions/dashboard-role')->with(['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::authorize('admin'))
            return view('roles_permissions/create-role');
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->only(['name', 'guard_name']));
        }

        $role = new Role;

        $role->name = $request->get('name');
        $role->guard_name = $request->get('guard_name');
        $role->save();

        return redirect()->route('role.index')->with(['success-created' => 'role created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return view('roles_permissions/show-role')->with(['role' => $role]);
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
            $role = Role::findOrFail($id);
            return view('roles_permissions/edit-role')->with(['role' => $role]);
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->only(['name', 'guard_name']));
        }

        $role = Role::findOrFail($id);

        $role->name = $request->get('name');
        $role->guard_name = $request->get('guard_name');
        $role->updated_at = now();
        $role->save();

        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('role.index')->with(['success-deleted' => 'the role has been deleted successfully']);
    }

    public function restore(Request $request)
    {
        $role = Role::onlyTrashed()->findOrFail($request->get('id'));
        $role->restore();

        return redirect()->route('role.index')->with(['success-restored' => 'the role has been restored successfully']);
    }
}
