<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold">Courses</h1>
                <p class="mt-1 text-sm text-slate-500">Create, organize, and share knowledge that makes a difference.</p>
            </div>
            <a href="{{ route('admin.courses.create') }}"
               class="rounded-lg bg-[#162A4A] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#1F3B63]">+ Create course</a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-[#E6F2EA] px-4 py-3 text-sm text-[#2E6B4A]">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-slate-100 bg-white">
        <table class="min-w-[700px] w-full text-sm">
            <thead class="bg-[#F5F8FC] text-left text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3 font-medium">Course name</th>
                    <th class="px-4 py-3 font-medium">Category</th>
                    <th class="px-4 py-3 font-medium">Lessons</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($courses as $course)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-[#E4EAF4] text-sm font-bold">
                                    {{ strtoupper(substr($course->title, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-semibold">{{ $course->title }}</div>
                                    <div class="text-xs text-slate-500">Updated {{ $course->updated_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-slate-600">{{ $course->category }}</td>
                        <td class="px-4 py-4">{{ $course->lessons_count }}</td>
                        <td class="px-4 py-4">
                            <span class="rounded-full px-3 py-1 text-xs
                                {{ $course->status === 'published' ? 'bg-[#E6F2EA] text-[#2E6B4A]' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($course->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-4">
                                <a class="font-medium text-[#2F5C9E]" href="{{ route('admin.courses.edit', $course) }}">Edit</a>
                                <a class="font-medium text-[#2F5C9E]" href="{{ route('admin.courses.lessons.index', $course) }}">Lessons</a>
                                <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                                      onsubmit="return confirm('Hapus course ini beserta lesson dan videonya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-slate-500 hover:text-red-600">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-10 text-center text-slate-500">Belum ada course.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $courses->links() }}</div>
</x-admin-layout>