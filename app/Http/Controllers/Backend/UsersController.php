<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\UserBlogsDataTable;
use App\DataTables\UsersDataTable;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        $this->authorize('viewAny', User::class);

        // Gate::authorize('viewAny', User::class);

        return $dataTable->render('backend.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('backend.users.create', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'userRoles' => [],
            'userPermissions' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => 'password',
        ]);

        event(new Registered($user));

        $user->assignRole($request->roles);
        $user->givePermissionTo($request->permissions);

        \Mail::to(Auth::user())->send(new \App\Mail\UserCreated($user));

        return redirect(route('backend.users.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id, UserBlogsDataTable $dataTables)
    {
        $user = User::with('blogs')->with('roles')->findOrFail($id);
        $this->authorize('view', $user);

        return $dataTables->render('backend.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $roles = Role::all();
        $permissions = Permission::all();
        $userRoles = [];
        $userPermissions = [];

        foreach ($user->roles as $role) {
            $userRoles[$role->id] = $role->id;
        }

        foreach ($user->permissions as $permission) {
            $userPermissions[$permission->id] = $permission->id;
        }

        return view('backend.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'userRoles' => $userRoles,
            'userPermissions' => $userPermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $user->update($request->all());
        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);

        return redirect(route('backend.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();

        return redirect(route('backend.users.index'));
    }
}
