<x-student-layout>
    <nav class="mb-4 text-sm text-slate-500">
        <a href="{{ route('student.courses.index') }}" class="hover:underline">Explore courses</a>
        <span class="mx-1">/</span>
        <span class="text-slate-700">{{ $course->title }}</span>
    </nav>

    {{-- Hero --}}
    <div class="rounded-2xl bg-[#162A4A] p-8 text-white sm:p-10">
        @if ($course->category)
            <span class="rounded-full bg-white/10 px-3 py-1 text-xs">{{ $course->category }}</span>
        @endif
        <h1 class="mt-4 text-3xl font-bold sm:text-4xl">{{ $course->title }}</h1>
        <p class="mt-3 max-w-2xl text-white/70">{{ $course->description }}</p>
        <div class="mt-6 text-sm text-white/80">
            {{ $course->level }} · {{ $course->lessons->count() }} {{ \Illuminate\Support\Str::plural('lesson', $course->lessons->count()) }}
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        {{-- Daftar lesson --}}
        <div class="rounded-xl border border-slate-100 bg-white lg:col-span-2">
            <div class="border-b border-slate-100 p-6">
                <h2 class="text-xl font-bold">Your course, at a glance</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $course->lessons->count() }} {{ \Illuminate\Support\Str::plural('lesson', $course->lessons->count()) }}</p>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse ($course->lessons as $lesson)
                    @php $ready = $lesson->video?->status === 'ready'; @endphp
                    <a href="{{ route('student.courses.lesson', [$course, $lesson]) }}"
                       class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-[#F5F8FC]">
                        <div class="flex items-center gap-4">
                            <span class="w-6 text-sm font-semibold text-[#2F5C9E]">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="font-medium">{{ $lesson->title }}</span>
                        </div>
                        <span class="shrink-0 text-sm {{ $ready ? 'font-medium text-[#2F5C9E]' : 'text-slate-400' }}">
                            {{ $ready ? 'Watch →' : 'Coming soon' }}
                        </span>
                    </a>
                @empty
                    <div class="p-8 text-center text-slate-500">Belum ada lesson di course ini.</div>
                @endforelse
            </div>
        </div>

        {{-- Aksi --}}
        <div class="h-fit rounded-xl border border-slate-100 bg-white p-6">
            <h2 class="text-xl font-bold">Ready to begin?</h2>
            <p class="mt-1 text-sm text-slate-500">Take the first step. Keep going.</p>

            @if ($course->lessons->isNotEmpty())
                <a href="{{ route('student.courses.lesson', [$course, $course->lessons->first()]) }}"
                   class="mt-5 block rounded-lg bg-[#162A4A] py-3 text-center text-sm font-semibold text-white hover:bg-[#1F3B63]">
                    Start learning →
                </a>
            @endif

            <div class="mt-5 space-y-1 text-sm text-slate-500">
                <div>{{ $course->lessons->count() }} video lessons</div>
                <div>Level: {{ $course->level }}</div>
            </div>
        </div>
    </div>
</x-student-layout>