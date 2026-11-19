<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('student.courses.index') }}" class="text-sm text-blue-700">← Explore courses</a>
        <h2 class="font-semibold text-xl text-gray-800">{{ $course->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <div class="text-xs text-blue-700">{{ $course->category }} · {{ $course->level }}</div>
                <p class="mt-2 text-gray-700">{{ $course->description }}</p>
            </div>

            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-4 border-b font-semibold">Lessons ({{ $course->lessons->count() }})</div>
                <div class="divide-y">
                    @forelse ($course->lessons as $lesson)
                        <a href="{{ route('student.courses.lesson', [$course, $lesson]) }}"
                           class="flex items-center justify-between p-4 hover:bg-gray-50">
                            <span>{{ $loop->iteration }}. {{ $lesson->title }}</span>
                            <span class="text-xs {{ $lesson->video?->status === 'ready' ? 'text-green-700' : 'text-gray-400' }}">
                                {{ $lesson->video?->status === 'ready' ? 'Watch →' : 'Belum tersedia' }}
                            </span>
                        </a>
                    @empty
                        <div class="p-6 text-center text-gray-500">Belum ada lesson.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>