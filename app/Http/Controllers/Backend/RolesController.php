<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\RolesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RolesDataTable $dataTable)
    {
        $this->authorize('viewAny', Role::class);

        return $dataTable->render('backend.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Role::class);
        $role = new Role();
        $permissions = Permission::all();
        $rolePermissions = [];

        return view('backend.roles.create', compact(['role', 'permissions', 'rolePermissions']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'guard_name' => 'nullable',
            'permissions' => 'nullable|array',
        ]);
        $guard = $request->gaurd_name ?? 'web';
        $role = Role::create(['name' => $request->name, 'guard_name' => $guard]);
        if ($request->permissions) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect(route('backend.roles.index'));
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
        $this->authorize('view', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $this->authorize('update', $role);
        $permissions = Permission::all();
        $rolePermissions = [];
        if ($role->permissions) {
            foreach ($role->permissions as $permission) {
                $rolePermissions[$permission->id] = $permission->id;
            }
        }

        return view('backend.roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $this->authorize('update', $role);
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,'.$id],
            'guard_name' => 'nullable',
            'permissions' => 'nullable|array',
        ]);
        $guard = $request->gaurd_name ?? 'web';
        $role->update(['name' => $request->name, 'guard_name' => $guard]);
        $role->syncPermissions($request->permissions);

        return redirect(route('backend.roles.index'));
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
        $this->authorize('delete', $role);
        $role->delete();

        return redirect(route('backend.roles.index'));
    }
}
