<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('student.courses.show', $course) }}" class="text-sm text-blue-700">← {{ $course->title }}</a>
        <h2 class="font-semibold text-xl text-gray-800">{{ $lesson->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-black sm:rounded-lg overflow-hidden">
                    @if ($videoReady)
                        <video controls class="w-full" src="{{ route('videos.stream', $lesson->video) }}"></video>
                    @else
                        <div class="p-16 text-center text-gray-300">Video belum tersedia.</div>
                    @endif
                </div>

                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <h3 class="font-semibold">{{ $lesson->title }}</h3>
                    <p class="mt-2 text-sm text-gray-700">{{ $lesson->description ?: 'Tidak ada deskripsi.' }}</p>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg h-fit">
                <div class="p-4 border-b font-semibold">Course content</div>
                <div class="divide-y">
                    @foreach ($course->lessons as $item)
                        <a href="{{ route('student.courses.lesson', [$course, $item]) }}"
                           class="block p-4 text-sm hover:bg-gray-50 {{ $item->id === $lesson->id ? 'bg-blue-50 font-medium' : '' }}">
                            {{ $loop->iteration }}. {{ $item->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>