<x-admin-layout>
    <x-slot name="header">
        <a href="{{ route('admin.courses.lessons.index', $course) }}" class="text-sm font-medium text-[#2F5C9E]">← Back to curriculum</a>
        <h1 class="mt-3 text-3xl font-bold">{{ $lesson->exists ? 'Edit lesson' : 'Add a video lesson' }}</h1>
        <p class="mt-1 text-sm text-slate-500">{{ $course->title }}</p>
    </x-slot>

@if (session('success'))
    <div class="mb-4 rounded-lg bg-[#E6F2EA] px-4 py-3 text-sm text-[#2E6B4A]">{{ session('success') }}</div>
@endif

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">

            {{-- Lesson details --}}
            <form method="POST"
                  action="{{ $lesson->exists ? route('admin.lessons.update', $lesson) : route('admin.courses.lessons.store', $course) }}"
                  class="rounded-xl border border-slate-100 bg-white p-6">
                @csrf
                @if ($lesson->exists) @method('PUT') @endif

                <h2 class="text-lg font-semibold">Lesson details</h2>

                <div class="mt-5 space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium">Lesson title *</label>
                        <input id="title" name="title" value="{{ old('title', $lesson->title) }}" required
                               class="mt-2 w-full rounded-lg border-slate-200 px-4 py-2.5 text-sm focus:border-[#2F5C9E] focus:ring-[#2F5C9E]">
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium">Description</label>
                        <textarea id="description" name="description" rows="4"
                                  class="mt-2 w-full rounded-lg border-slate-200 px-4 py-2.5 text-sm focus:border-[#2F5C9E] focus:ring-[#2F5C9E]">{{ old('description', $lesson->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button class="rounded-lg bg-[#162A4A] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1F3B63]">Save</button>
                    <a href="{{ route('admin.courses.lessons.index', $course) }}"
                       class="rounded-lg border border-slate-200 px-5 py-2.5 text-sm font-medium">Cancel</a>
                </div>
            </form>

            {{-- Lesson video --}}
            @if ($lesson->exists)
                @php $status = $lesson->video?->status; @endphp
                <div class="rounded-xl border border-slate-100 bg-white p-6">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <h2 class="text-lg font-semibold">Lesson video</h2>
                        <span class="rounded-full px-3 py-1 text-xs
                            {{ $status === 'ready' ? 'bg-[#E6F2EA] text-[#2E6B4A]' : ($status === 'failed' ? 'bg-red-50 text-red-600' : 'bg-slate-100 text-slate-600') }}">
                            {{ $status ? ucfirst($status) : 'No video yet' }}
                        </span>
                    </div>

                    @if ($lesson->video?->original_filename)
                        <p class="mt-2 text-sm text-slate-500">{{ $lesson->video->original_filename }}</p>
                    @endif

                    @if ($status === 'ready')
                        <video controls class="mt-4 w-full max-w-xl rounded-lg"
                               src="{{ route('videos.stream', $lesson->video) }}"></video>
                    @endif

                    <div class="mt-5 rounded-xl border-2 border-dashed border-[#9DB3D3] p-6 text-center">
                        <div class="text-sm font-medium">Choose a video to upload</div>
                        <div class="mt-1 text-xs text-slate-500">MP4, MOV or WebM · Up to 500 MB</div>
                        <input type="file" id="video-file" accept="video/mp4,video/quicktime,video/webm"
                               class="mt-4 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-[#E4EAF4] file:px-4 file:py-2 file:text-sm file:font-medium file:text-[#162A4A]">
                    </div>

                    <div class="mt-4 flex gap-3">
                        <button type="button" id="upload-btn"
                                class="rounded-lg bg-[#162A4A] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1F3B63] disabled:opacity-50">Upload</button>
                        <button type="button" id="retry-btn"
                                class="hidden rounded-lg border border-[#2F5C9E] px-5 py-2.5 text-sm font-medium text-[#2F5C9E]">Retry</button>
                    </div>

                    <div id="progress-wrap" class="mt-4 hidden h-2 rounded-full bg-[#E4EAF4]">
                        <div id="progress-bar" class="h-2 rounded-full bg-[#2F5C9E]" style="width:0%"></div>
                    </div>
                    <p id="progress-text" class="mt-2 text-sm"></p>
                </div>

                <script>
                    (function () {
                        const input = document.getElementById('video-file');
                        const uploadBtn = document.getElementById('upload-btn');
                        const retryBtn = document.getElementById('retry-btn');
                        const wrap = document.getElementById('progress-wrap');
                        const bar = document.getElementById('progress-bar');
                        const text = document.getElementById('progress-text');
                        let lastFile = null;

                        function fail(msg) {
                            text.textContent = 'Failed: ' + msg;
                            text.className = 'mt-2 text-sm text-red-600';
                            uploadBtn.disabled = false;
                            retryBtn.classList.remove('hidden');
                        }

                        function upload(file) {
                            lastFile = file;
                            uploadBtn.disabled = true;
                            retryBtn.classList.add('hidden');
                            wrap.classList.remove('hidden');
                            bar.style.width = '0%';
                            text.className = 'mt-2 text-sm text-[#2F5C9E]';
                            text.textContent = 'Uploading 0%';

                            const data = new FormData();
                            data.append('video', file);

                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', "{{ route('admin.lessons.video.store', $lesson) }}");
                            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                            xhr.setRequestHeader('Accept', 'application/json');

                            xhr.upload.onprogress = function (e) {
                                if (!e.lengthComputable) return;
                                const pct = Math.round((e.loaded / e.total) * 100);
                                bar.style.width = pct + '%';
                                text.textContent = pct < 100 ? 'Uploading ' + pct + '%' : 'Processing on server...';
                            };

                            xhr.onload = function () {
                                if (xhr.status >= 200 && xhr.status < 300) {
                                    text.textContent = 'Upload complete. Status: ready';
                                    setTimeout(() => location.reload(), 800);
                                    return;
                                }
                                let msg = 'Something went wrong (' + xhr.status + ').';
                                try {
                                    const json = JSON.parse(xhr.responseText);
                                    msg = (json.errors && json.errors.video) ? json.errors.video[0] : (json.message || msg);
                                } catch (e) {}
                                fail(msg);
                            };

                            xhr.onerror = () => fail('Connection lost.');
                            xhr.send(data);
                        }

                        uploadBtn.addEventListener('click', function () {
                            if (!input.files.length) { fail('Choose a video file first.'); return; }
                            upload(input.files[0]);
                        });
                        retryBtn.addEventListener('click', () => lastFile && upload(lastFile));
                    })();
                </script>
            @endif
        </div>

        {{-- Sisi kanan: tips --}}
        <div class="space-y-6">
            <div class="rounded-xl bg-[#E4EAF4] p-6">
                <h3 class="font-semibold">A great video makes it click.</h3>
                <ul class="mt-3 list-disc space-y-2 pl-5 text-sm text-slate-600">
                    <li>Use 1080p resolution or higher</li>
                    <li>Keep your audio crisp and clear</li>
                    <li>Aim for 5 to 20 minutes per lesson</li>
                    <li>Add captions for accessibility</li>
                </ul>
            </div>
            @unless ($lesson->exists)
                <div class="rounded-xl border border-slate-100 bg-white p-6 text-sm text-slate-600">
                    Save the lesson first. The video upload appears once the lesson exists.
                </div>
            @endunless
        </div>
    </div>
</x-admin-layout>