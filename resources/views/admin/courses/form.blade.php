<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ $course->exists ? 'Edit Course' : 'Create Course' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST"
                  action="{{ $course->exists ? route('admin.courses.update', $course) : route('admin.courses.store') }}"
                  class="bg-white p-6 shadow sm:rounded-lg space-y-4">
                @csrf
                @if ($course->exists) @method('PUT') @endif

                <div>
                    <x-input-label for="title" value="Course title *" />
                    <x-text-input id="title" name="title" class="block mt-1 w-full"
                                  :value="old('title', $course->title)" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="category" value="Category" />
                        <x-text-input id="category" name="category" class="block mt-1 w-full"
                                      :value="old('category', $course->category)" />
                        <x-input-error :messages="$errors->get('category')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="level" value="Level *" />
                        <select id="level" name="level" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @foreach (['Beginner', 'Intermediate', 'Advanced'] as $lvl)
                                <option value="{{ $lvl }}" @selected(old('level', $course->level) === $lvl)>{{ $lvl }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <x-input-label for="description" value="Course description *" />
                    <textarea id="description" name="description" rows="4" required
                              class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $course->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                <div>
                    <x-input-label value="Visibility" />
                    @foreach (['published' => 'Published (tampil di katalog student)', 'draft' => 'Draft (hanya admin)'] as $value => $label)
                        <label class="flex items-center gap-2 mt-2">
                            <input type="radio" name="status" value="{{ $value }}"
                                   @checked(old('status', $course->status ?: 'draft') === $value)>
                            <span class="text-sm">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="flex gap-3 pt-2">
                    <x-primary-button>Save</x-primary-button>
                    <a href="{{ route('admin.courses.index') }}" class="px-4 py-2 border rounded-md text-sm">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>