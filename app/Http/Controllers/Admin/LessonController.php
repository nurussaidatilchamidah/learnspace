<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        $lessons = $course->lessons()->with('video')->get();

        return view('admin.lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course)
    {
        return view('admin.lessons.form', ['course' => $course, 'lesson' => new Lesson()]);
    }

public function store(Request $request, Course $course)
{
    $data = $this->validated($request);
    $data['sort_order'] = ($course->lessons()->max('sort_order') ?? 0) + 1;

    $lesson = $course->lessons()->create($data);

    return redirect()->route('admin.lessons.edit', $lesson)
        ->with('success', 'Lesson dibuat. Sekarang upload videonya.');
}

    public function edit(Lesson $lesson)
    {
        return view('admin.lessons.form', ['course' => $lesson->course, 'lesson' => $lesson]);
    }

    public function update(Request $request, Lesson $lesson)
    {
        $lesson->update($this->validated($request));

        return redirect()->route('admin.courses.lessons.index', $lesson->course_id)
            ->with('success', 'Lesson berhasil diperbarui.');
    }

    public function destroy(Lesson $lesson)
    {
        $courseId = $lesson->course_id;
        // TODO nanti: hapus juga file video fisiknya dari storage
        $lesson->delete();

        // Rapikan ulang urutan supaya tetap 1,2,3...
        Lesson::where('course_id', $courseId)->orderBy('sort_order')->get()
            ->each(fn ($l, $i) => $l->update(['sort_order' => $i + 1]));

        return redirect()->route('admin.courses.lessons.index', $courseId)
            ->with('success', 'Lesson berhasil dihapus.');
    }

    public function move(Lesson $lesson, string $direction)
    {
        $query = Lesson::where('course_id', $lesson->course_id);

        $neighbor = $direction === 'up'
            ? $query->where('sort_order', '<', $lesson->sort_order)->orderByDesc('sort_order')->first()
            : $query->where('sort_order', '>', $lesson->sort_order)->orderBy('sort_order')->first();

        if ($neighbor) {
            [$a, $b] = [$lesson->sort_order, $neighbor->sort_order];
            $lesson->update(['sort_order' => $b]);
            $neighbor->update(['sort_order' => $a]);
        }

        return back();
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);
    }
}