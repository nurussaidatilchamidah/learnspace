<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Explore courses</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($courses as $course)
                    <a href="{{ route('student.courses.show', $course) }}"
                       class="block bg-white p-5 shadow sm:rounded-lg hover:shadow-md transition">
                        <div class="text-xs text-blue-700">{{ $course->category }} · {{ $course->level }}</div>
                        <h3 class="mt-1 font-semibold text-lg text-gray-900">{{ $course->title }}</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($course->description, 110) }}</p>
                        <div class="mt-4 text-xs text-gray-500">{{ $course->lessons_count }} lessons</div>
                    </a>
                @empty
                    <p class="text-gray-500">Belum ada course yang dipublikasikan.</p>
                @endforelse
            </div>

            <div class="mt-6">{{ $courses->links() }}</div>
        </div>
    </div>
</x-app-layout>