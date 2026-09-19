<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    public function index(Request $request) {
        $query = User::with('role');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }
        if ($request->role) {
            $query->where('role_id', $request->role);
        }
        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }

        $users = $query->latest()->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function show(User $user) {
        $user->load('role');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user) {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'phone'   => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'city'    => 'nullable|string|max:100',
        ]);

        $user->update($request->only(['name', 'email', 'role_id', 'phone', 'country', 'city']));

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    public function toggleStatus(User $user) {
        // Admin khud ko deactivate nahi kar sakta
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Aap apna account deactivate nahi kar sakte!');
        }
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "User {$status} successfully!");
    }

    public function destroy(User $user) {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Aap apna account delete nahi kar sakte!');
        }
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }
}