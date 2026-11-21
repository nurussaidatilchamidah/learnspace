<x-student-layout>
    {{-- Banner --}}
    <div class="rounded-2xl bg-[#162A4A] p-8 text-white sm:p-10">
        <div class="text-[11px] tracking-widest text-white/60">YOUR NEXT CHAPTER</div>
        <h1 class="mt-3 text-3xl font-bold sm:text-4xl">Make today a learning day.</h1>
        <p class="mt-3 text-white/70">Practical skills. Expert guidance. Possibilities that grow with you.</p>
    </div>

    <div class="mt-10 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold">Explore courses</h2>
            <p class="mt-1 text-sm text-slate-500">Find the right course for your next step.</p>
        </div>
        <div class="text-sm text-slate-500">{{ $courses->total() }} published {{ \Illuminate\Support\Str::plural('course', $courses->total()) }}</div>
    </div>

    {{-- Filter kategori --}}
    <div class="mt-5 flex flex-wrap gap-2">
        <a href="{{ route('student.courses.index') }}"
           class="rounded-full border px-4 py-2 text-sm {{ request('category') ? 'border-slate-200 bg-white text-slate-600' : 'border-[#162A4A] bg-[#162A4A] font-medium text-white' }}">
            All courses
        </a>
        @foreach ($categories as $cat)
            <a href="{{ route('student.courses.index', ['category' => $cat]) }}"
               class="rounded-full border px-4 py-2 text-sm {{ request('category') === $cat ? 'border-[#162A4A] bg-[#162A4A] font-medium text-white' : 'border-slate-200 bg-white text-slate-600' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    {{-- Kartu course --}}
    @php
        $tints = ['#E4EAF4', '#E1EEE8', '#EAE4F2', '#F1EAE0', '#E3EAF0'];

        // Ikon sederhana (SVG path) per kategori, dicocokkan dari kata kunci
        $icons = [
            'design'   => 'M4 20l4-1 11-11-3-3L5 16z M14 6l3 3',
            'develop'  => 'M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5',
            'business' => 'M3 8h18v11H3z M9 8V5h6v3 M3 13h18',
            'data'     => 'M5 20V12 M12 20V5 M19 20V9',
            'soft'     => 'M4 5h16v11H9l-5 4z',
            'default'  => 'M4 5h7a1 1 0 0 1 1 1v13a2 2 0 0 0-2-2H4z M20 5h-7a1 1 0 0 0-1 1v13a2 2 0 0 1 2-2h6z',
        ];
    @endphp
    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($courses as $course)
            @php
                $cat = strtolower($course->category ?? '');
                $key = collect(array_keys($icons))->first(fn ($k) => $k !== 'default' && str_contains($cat, $k)) ?? 'default';
            @endphp
            <a href="{{ route('student.courses.show', $course) }}"
               class="block rounded-xl border border-slate-100 bg-white p-3 transition hover:shadow-md">
                <div class="flex items-center justify-between rounded-lg px-5 py-6" style="background: {{ $tints[$course->id % 5] }}">
                    <div>
                        <div class="text-[10px] font-semibold uppercase tracking-wide text-[#2F5C9E]">{{ $course->category ?: 'Course' }}</div>
                        <div class="mt-1 text-sm font-medium text-[#162A4A]/70">{{ $course->level }}</div>
                    </div>
                    <svg class="h-12 w-12 text-[#162A4A]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="{{ $icons[$key] }}"/>
                    </svg>
                </div>
                <div class="px-2 pb-2 pt-4">
                    <h3 class="text-lg font-semibold">{{ $course->title }}</h3>
                    <p class="mt-1 line-clamp-2 text-sm text-slate-500">{{ $course->description }}</p>
                    <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3 text-xs">
                        <span class="text-slate-500">{{ $course->lessons_count }} {{ \Illuminate\Support\Str::plural('lesson', $course->lessons_count) }}</span>
                        <span class="font-semibold text-[#2F5C9E]">View course →</span>
                    </div>
                </div>
            </a>
        @empty
            <p class="text-slate-500 sm:col-span-2 lg:col-span-3">Belum ada course yang dipublikasikan.</p>
        @endforelse
    </div>

    <div class="mt-8">{{ $courses->links() }}</div>
</x-student-layout>