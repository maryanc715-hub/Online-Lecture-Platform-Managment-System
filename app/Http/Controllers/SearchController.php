<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\LectureMaterial;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('q', ''));

        $courses = collect();
        $users = collect();
        $assignments = collect();
        $lectures = collect();

        if ($query !== '') {
            $user = auth()->user();

            $coursesQuery = Course::with(['category', 'instructor'])
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                });

            if ($user->hasRole('instructor')) {
                $coursesQuery->where('instructor_id', $user->id);
            } elseif ($user->hasRole('student')) {
                $coursesQuery->whereHas('students', fn ($q) => $q->where('users.id', $user->id));
            }

            $courses = $coursesQuery->limit(10)->get();

            if ($user->hasRole('admin')) {
                $users = User::with('role')
                    ->where(function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%")
                          ->orWhere('email', 'like', "%{$query}%")
                          ->orWhere('student_id', 'like', "%{$query}%");
                    })
                    ->limit(10)
                    ->get();
            }

            $assignmentsQuery = Assignment::with('course')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                });

            if ($user->hasRole('instructor')) {
                $assignmentsQuery->where('instructor_id', $user->id);
            } elseif ($user->hasRole('student')) {
                $assignmentsQuery->whereHas('course.students', fn ($q) => $q->where('users.id', $user->id));
            }

            $assignments = $assignmentsQuery->limit(10)->get();

            $lecturesQuery = LectureMaterial::with('course')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                });

            if ($user->hasRole('instructor')) {
                $lecturesQuery->where('instructor_id', $user->id);
            } elseif ($user->hasRole('student')) {
                $lecturesQuery->where('visibility', 'public')
                    ->whereHas('course.students', fn ($q) => $q->where('users.id', $user->id));
            }

            $lectures = $lecturesQuery->limit(10)->get();
        }

        return view('search.index', compact('query', 'courses', 'users', 'assignments', 'lectures'));
    }
}
