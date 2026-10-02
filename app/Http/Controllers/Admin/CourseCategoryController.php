<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::withCount('courses')->latest()->paginate(15);

        return view('admin.course-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.course-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category = CourseCategory::create($validated);

        ActivityLog::record('course_category.created', "Created category {$category->name}", $category);

        return redirect()->route('admin.course-categories.index')->with('success', 'Category created successfully.');
    }

    public function show(CourseCategory $courseCategory)
    {
        $courseCategory->load(['courses.instructor']);

        return view('admin.course-categories.show', ['category' => $courseCategory]);
    }

    public function edit(CourseCategory $courseCategory)
    {
        return view('admin.course-categories.edit', ['category' => $courseCategory]);
    }

    public function update(Request $request, CourseCategory $courseCategory)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('course_categories')->ignore($courseCategory->id)],
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $courseCategory->update($validated);

        ActivityLog::record('course_category.updated', "Updated category {$courseCategory->name}", $courseCategory);

        return redirect()->route('admin.course-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(CourseCategory $courseCategory)
    {
        abort_if($courseCategory->courses()->exists(), 422, 'Cannot delete a category that has courses assigned.');

        $name = $courseCategory->name;
        $courseCategory->delete();

        ActivityLog::record('course_category.deleted', "Deleted category {$name}");

        return back()->with('success', 'Category deleted successfully.');
    }
}
