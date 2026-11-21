@php
    $lessons = $course->lessons->values();
    $idx = $lessons->search(fn ($l) => $l->id === $lesson->id);
    $prev = $idx > 0 ? $lessons[$idx - 1] : null;
    $next = $lessons[$idx + 1] ?? null;
@endphp

<x-student-layout>
    <nav class="mb-4 text-sm text-slate-500">
        <a href="{{ route('student.courses.show', $course) }}" class="hover:underline">← {{ $course->title }}</a>
    </nav>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-5 lg:col-span-2">
            {{-- Video --}}
            <div class="overflow-hidden rounded-2xl bg-[#162A4A]">
                @if ($videoReady)
                    <video controls class="aspect-video w-full bg-black" src="{{ route('videos.stream', $lesson->video) }}"></video>
                @else
                    <div class="flex aspect-video flex-col items-center justify-center px-6 text-center text-white">
                        <div class="text-2xl font-bold">Video belum tersedia</div>
                        <p class="mt-2 text-sm text-white/60">Lesson ini belum memiliki video yang siap ditonton. Coba lagi nanti.</p>
                    </div>
                @endif
            </div>

            {{-- Judul + navigasi --}}
            <div>
                <div class="text-xs font-semibold uppercase tracking-wide text-[#2F5C9E]">
                    Lesson {{ $idx + 1 }} of {{ $lessons->count() }}
                </div>
                <h1 class="mt-1 text-2xl font-bold sm:text-3xl">{{ $lesson->title }}</h1>
                <p class="mt-1 text-sm text-slate-500">{{ $course->title }}</p>
            </div>

            <div class="rounded-xl border border-slate-100 bg-white p-6">
                <h2 class="font-semibold">About this lesson</h2>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $lesson->description ?: 'Tidak ada deskripsi untuk lesson ini.' }}</p>
            </div>

            <div class="flex items-center justify-between gap-3">
                @if ($prev)
                    <a href="{{ route('student.courses.lesson', [$course, $prev]) }}"
                       class="rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium">← Previous lesson</a>
                @else
                    <span></span>
                @endif
                @if ($next)
                    <a href="{{ route('student.courses.lesson', [$course, $next]) }}"
                       class="rounded-lg bg-[#162A4A] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1F3B63]">Next lesson →</a>
                @endif
            </div>
        </div>

        {{-- Daftar lesson --}}
        <div class="h-fit rounded-xl border border-slate-100 bg-white">
            <div class="border-b border-slate-100 p-5">
                <h2 class="font-semibold">Course content</h2>
                <p class="mt-1 text-xs text-slate-500">{{ $lessons->count() }} {{ \Illuminate\Support\Str::plural('lesson', $lessons->count()) }}</p>
            </div>
            <div class="p-2">
                @foreach ($lessons as $item)
                    @php $current = $item->id === $lesson->id; $ready = $item->video?->status === 'ready'; @endphp
                    <a href="{{ route('student.courses.lesson', [$course, $item]) }}"
                       class="flex items-start gap-3 rounded-lg px-3 py-3 text-sm {{ $current ? 'bg-[#E4EAF4]' : 'hover:bg-[#F5F8FC]' }}">
                        <span class="mt-0.5 text-[#2F5C9E]">{{ $current ? '▶' : '▷' }}</span>
                        <span>
                            <span class="block {{ $current ? 'font-semibold' : 'font-medium' }}">{{ $item->title }}</span>
                            <span class="block text-xs {{ $current ? 'text-[#2F5C9E]' : 'text-slate-400' }}">
                                {{ $current ? 'Now playing' : ($ready ? 'Video ready' : 'Coming soon') }}
                            </span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-student-layout>