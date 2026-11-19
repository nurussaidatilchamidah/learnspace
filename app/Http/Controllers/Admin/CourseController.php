<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('lessons')->latest()->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.form', ['course' => new Course()]);
    }

    public function store(Request $request)
    {
        Course::create($this->validated($request));

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil dibuat.');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.form', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $course->update($this->validated($request));

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        // TODO nanti: hapus juga file video fisik milik lesson-lesson course ini
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'level' => ['required', 'in:Beginner,Intermediate,Advanced'],
            'status' => ['required', 'in:draft,published'],
        ]);
    }
}