<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('status', 'published')
            ->withCount('lessons')
            ->latest()
            ->paginate(9);

        return view('student.courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        abort_unless($course->status === 'published', 404);

        $course->load('lessons.video');

        return view('student.courses.show', compact('course'));
    }

    public function lesson(Course $course, Lesson $lesson)
    {
        abort_unless($course->status === 'published', 404);
        abort_unless($lesson->course_id === $course->id, 404);

        $course->load('lessons.video');
        $lesson->load('video');

        $videoReady = $lesson->video && $lesson->video->status === 'ready';

        return view('student.courses.lesson', compact('course', 'lesson', 'videoReady'));
    }
}