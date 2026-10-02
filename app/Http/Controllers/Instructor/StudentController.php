<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $users = $this->students()
            ->when($request->role, fn ($q) => $q->whereHas('role', fn ($r) => $r->where('name', $request->role)))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $roles = Role::where('name', 'student')->get();

        return view('instructor.students.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::where('name', 'student')->get();

        return view('instructor.students.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_id' => ['required', Rule::exists('roles', 'id')->where('name', 'student')],
            'phone' => 'nullable|string|max:30',
            'password' => 'required|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        ActivityLog::record('user.created', "Created student {$user->name}", $user);

        return redirect()->route('instructor.students.index')->with('success', 'Student created successfully.');
    }

    public function show(User $student)
    {
        $this->ensureStudent($student);
        $student->load('role');

        return view('instructor.students.show', ['user' => $student]);
    }

    public function edit(User $student)
    {
        $this->ensureStudent($student);
        $roles = Role::where('name', 'student')->get();

        return view('instructor.students.edit', ['user' => $student, 'roles' => $roles]);
    }

    public function update(Request $request, User $student)
    {
        $this->ensureStudent($student);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($student->id)],
            'role_id' => ['required', Rule::exists('roles', 'id')->where('name', 'student')],
            'phone' => 'nullable|string|max:30',
            'status' => 'required|in:active,pending,inactive,suspended',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $student->update($validated);

        ActivityLog::record('user.updated', "Updated student {$student->name}", $student);

        return redirect()->route('instructor.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(User $student)
    {
        $this->ensureStudent($student);

        abort_if($student->id === auth()->id(), 422, 'You cannot delete your own account.');

        $name = $student->name;

        $student->forceDelete();

        ActivityLog::record('user.deleted', "Permanently deleted student {$name}");

        return back()->with('success', 'Student permanently deleted.');
    }

    public function approve(User $student)
    {
        $this->ensureStudent($student);

        $student->update(['status' => 'active']);

        Notification::notify(
            (string) $student->id,
            'account',
            'Account approved',
            'Your account has been approved. You can now log in and use the platform.'
        );

        ActivityLog::record('user.approved', "Approved student {$student->name}", $student);

        return back()->with('success', "{$student->name} has been approved.");
    }

    private function students(): Builder
    {
        return User::with('role')->whereHas('role', fn ($q) => $q->where('name', 'student'));
    }

    private function ensureStudent(User $student): void
    {
        abort_unless($student->hasRole('student'), 404);
    }
}
