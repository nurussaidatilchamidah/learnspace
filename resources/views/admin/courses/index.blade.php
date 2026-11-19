<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Courses</h2>
            <a href="{{ route('admin.courses.create') }}"
               class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md">+ Create course</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Course</th>
                            <th class="px-4 py-3">Category</th>
                            <th class="px-4 py-3">Lessons</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($courses as $course)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $course->title }}</td>
                                <td class="px-4 py-3">{{ $course->category }}</td>
                                <td class="px-4 py-3">{{ $course->lessons_count }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs
                                        {{ $course->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 flex gap-3">
                                    <a class="text-blue-700" href="{{ route('admin.courses.edit', $course) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                                          onsubmit="return confirm('Hapus course ini beserta lesson dan videonya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada course.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $courses->links() }}</div>
        </div>
    </div>
</x-app-layout>