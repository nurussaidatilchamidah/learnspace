<x-admin-layout>
    <x-slot name="header">
        <a href="{{ route('admin.courses.index') }}" class="text-sm font-medium text-[#2F5C9E]">← Back to courses</a>
        <div class="mt-3 text-xs font-semibold tracking-wide text-[#2F5C9E]">COURSE EDITOR</div>
        <h1 class="mt-1 text-3xl font-bold">{{ $course->exists ? $course->title : 'New course' }}</h1>
        <p class="mt-1 text-sm text-slate-500">Create a course or update its details, then choose when students can see it.</p>
    </x-slot>

    <form method="POST"
          action="{{ $course->exists ? route('admin.courses.update', $course) : route('admin.courses.store') }}"
          class="grid gap-6 lg:grid-cols-3">
        @csrf
        @if ($course->exists) @method('PUT') @endif

        {{-- Course details --}}
        <div class="rounded-xl border border-slate-100 bg-white p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold">Course details</h2>

            <div class="mt-5 space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium">Course title *</label>
                    <input id="title" name="title" value="{{ old('title', $course->title) }}" required
                           class="mt-2 w-full rounded-lg border-slate-200 px-4 py-2.5 text-sm focus:border-[#2F5C9E] focus:ring-[#2F5C9E]">
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="category" class="block text-sm font-medium">Category</label>
                        <input id="category" name="category" value="{{ old('category', $course->category) }}"
                               class="mt-2 w-full rounded-lg border-slate-200 px-4 py-2.5 text-sm focus:border-[#2F5C9E] focus:ring-[#2F5C9E]">
                        <x-input-error :messages="$errors->get('category')" class="mt-1" />
                    </div>
                    <div>
                        <label for="level" class="block text-sm font-medium">Level *</label>
                        <select id="level" name="level"
                                class="mt-2 w-full rounded-lg border-slate-200 px-4 py-2.5 text-sm focus:border-[#2F5C9E] focus:ring-[#2F5C9E]">
                            @foreach (['Beginner', 'Intermediate', 'Advanced'] as $lvl)
                                <option value="{{ $lvl }}" @selected(old('level', $course->level) === $lvl)>{{ $lvl }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium">Course description *</label>
                    <textarea id="description" name="description" rows="5" required
                              class="mt-2 w-full rounded-lg border-slate-200 px-4 py-2.5 text-sm focus:border-[#2F5C9E] focus:ring-[#2F5C9E]">{{ old('description', $course->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>
                <p class="text-xs text-slate-500">* Required fields</p>
            </div>
        </div>

        {{-- Publishing --}}
        <div class="h-fit rounded-xl border border-slate-100 bg-white p-6">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Publishing</h2>
                @if ($course->exists)
                    <span class="rounded-full px-3 py-1 text-xs {{ $course->status === 'published' ? 'bg-[#E6F2EA] text-[#2E6B4A]' : 'bg-slate-100 text-slate-600' }}">
                        {{ ucfirst($course->status) }}
                    </span>
                @endif
            </div>

            <div class="mt-5 text-sm font-medium">Visibility</div>
            <div class="mt-2 space-y-3">
                @foreach (['published' => ['Published', 'Visible in the student course catalog'], 'draft' => ['Draft', 'Only administrators can view this course']] as $value => [$label, $hint])
                    <label class="flex cursor-pointer gap-3 rounded-lg border border-slate-200 p-3 has-[:checked]:border-[#2F5C9E] has-[:checked]:bg-[#F5F8FC]">
                        <input type="radio" name="status" value="{{ $value }}"
                               class="mt-1 text-[#162A4A] focus:ring-[#162A4A]"
                               @checked(old('status', $course->status ?: 'draft') === $value)>
                        <span>
                            <span class="block text-sm font-medium">{{ $label }}</span>
                            <span class="block text-xs text-slate-500">{{ $hint }}</span>
                        </span>
                    </label>
                @endforeach
            </div>

            <div class="mt-5 flex gap-3">
                <button class="flex-1 rounded-lg bg-[#162A4A] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#1F3B63]">
                    {{ $course->exists ? 'Save changes' : 'Create course' }}
                </button>
                <a href="{{ route('admin.courses.index') }}"
                   class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-medium">Cancel</a>
            </div>
            <p class="mt-4 text-xs text-slate-500">A new course starts as a draft. Publish it once its details and lessons are ready.</p>
        </div>
    </form>

    {{-- Hapus course (form terpisah, tidak boleh bersarang) --}}
    @if ($course->exists)
        <div class="mt-6 flex flex-wrap items-center justify-between gap-4 rounded-xl border border-slate-100 bg-white p-6">
            <div>
                <h2 class="text-lg font-semibold">Delete {{ $course->title }}?</h2>
                <p class="mt-1 text-sm text-slate-500">This permanently deletes the course, its lessons, and uploaded videos. This action cannot be undone.</p>
            </div>
            <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                  onsubmit="return confirm('Hapus course ini beserta lesson dan videonya?')">
                @csrf
                @method('DELETE')
                <button class="rounded-lg bg-[#162A4A] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1F3B63]">Delete course</button>
            </form>
        </div>
    @endif
</x-admin-layout>