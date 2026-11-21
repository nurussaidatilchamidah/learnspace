<x-admin-layout>
    <x-slot name="header">
        <a href="{{ route('admin.courses.index') }}" class="text-sm font-medium text-[#2F5C9E]">← Back to courses</a>
        <div class="mt-3 flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold">{{ $course->title }}</h1>
                <p class="mt-1 text-sm text-slate-500">Manage your course content and create a great learning experience.</p>
            </div>
            <a href="{{ route('admin.courses.lessons.create', $course) }}"
               class="rounded-lg bg-[#162A4A] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#1F3B63]">+ Add lesson</a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-[#E6F2EA] px-4 py-3 text-sm text-[#2E6B4A]">{{ session('success') }}</div>
    @endif

    <div class="rounded-xl border border-slate-100 bg-white">
        <div class="border-b border-slate-100 p-6">
            <h2 class="text-lg font-semibold">Course curriculum</h2>
            <p class="mt-1 text-sm text-slate-500">{{ $lessons->count() }} {{ \Illuminate\Support\Str::plural('lesson', $lessons->count()) }}</p>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse ($lessons as $lesson)
                @php $status = $lesson->video?->status; @endphp
                <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4">
                    <div class="min-w-0">
                        <div class="font-medium">{{ $loop->iteration }}. {{ $lesson->title }}</div>
                        <div class="mt-0.5 text-xs">
                            @if ($status === 'ready')
                                <span class="text-[#2E6B4A]">Video ready</span>
                            @elseif ($status === 'failed')
                                <span class="text-red-600">Upload failed</span>
                            @elseif ($status === 'uploading')
                                <span class="text-[#2F5C9E]">Uploading</span>
                            @else
                                <span class="text-slate-400">No video yet</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3 text-sm">
                        <form method="POST" action="{{ route('admin.lessons.move', [$lesson, 'up']) }}">
                            @csrf
                            <button class="h-8 w-8 rounded-lg border border-slate-200 disabled:opacity-30" @disabled($loop->first)>↑</button>
                        </form>
                        <form method="POST" action="{{ route('admin.lessons.move', [$lesson, 'down']) }}">
                            @csrf
                            <button class="h-8 w-8 rounded-lg border border-slate-200 disabled:opacity-30" @disabled($loop->last)>↓</button>
                        </form>
                        <a class="font-medium text-[#2F5C9E]" href="{{ route('admin.lessons.edit', $lesson) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.lessons.destroy', $lesson) }}"
                              onsubmit="return confirm('Hapus lesson ini beserta videonya?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-slate-500 hover:text-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-slate-500">Belum ada lesson. Klik “+ Add lesson” untuk memulai.</div>
            @endforelse
        </div>
    </div>
</x-admin-layout>