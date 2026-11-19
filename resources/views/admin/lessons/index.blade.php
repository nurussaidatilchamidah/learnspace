<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ route('admin.courses.index') }}" class="text-sm text-blue-700">← Back to courses</a>
                <h2 class="font-semibold text-xl text-gray-800">{{ $course->title }}: Lessons</h2>
            </div>
            <a href="{{ route('admin.courses.lessons.create', $course) }}"
               class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md">+ Add lesson</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow sm:rounded-lg divide-y">
                @forelse ($lessons as $lesson)
                    <div class="p-4 flex items-center justify-between gap-4">
                        <div>
                            <div class="font-medium">{{ $loop->iteration }}. {{ $lesson->title }}</div>
                            <div class="text-xs text-gray-500">
                                Video: {{ $lesson->video?->status ?? 'belum ada' }}
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-sm">
                            <form method="POST" action="{{ route('admin.lessons.move', [$lesson, 'up']) }}">
                                @csrf
                                <button class="px-2 py-1 border rounded disabled:opacity-30" @disabled($loop->first)>↑</button>
                            </form>
                            <form method="POST" action="{{ route('admin.lessons.move', [$lesson, 'down']) }}">
                                @csrf
                                <button class="px-2 py-1 border rounded disabled:opacity-30" @disabled($loop->last)>↓</button>
                            </form>
                            <a class="text-blue-700" href="{{ route('admin.lessons.edit', $lesson) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.lessons.destroy', $lesson) }}"
                                  onsubmit="return confirm('Hapus lesson ini beserta videonya?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">Belum ada lesson.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>