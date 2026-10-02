<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('role')
            ->when($request->role, fn ($q) => $q->whereHas('role', fn ($r) => $r->where('name', $request->role)))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:30',
            'password' => 'required|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        ActivityLog::record('user.created', "Created user {$user->name}", $user);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:30',
            'status' => 'required|in:active,pending,inactive,suspended',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        ActivityLog::record('user.updated', "Updated user {$user->name}", $user);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        abort_if($user->id === auth()->id(), 422, 'You cannot delete your own account.');

        abort_if(
            $user->coursesTaught()->exists(),
            422,
            'Cannot delete a user who still teaches courses. Reassign or delete their courses first.'
        );

        $name = $user->name;

        $user->forceDelete();

        ActivityLog::record('user.deleted', "Permanently deleted user {$name}");

        return back()->with('success', 'User permanently deleted.');
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'active']);

        Notification::notify(
            (string) $user->id,
            'account',
            'Account approved',
            'Your account has been approved. You can now log in and use the platform.'
        );

        ActivityLog::record('user.approved', "Approved user {$user->name}", $user);

        return back()->with('success', "{$user->name} has been approved.");
    }

    public function show(User $user)
    {
        $user->load('role');

        return view('admin.users.show', compact('user'));
    }
}
