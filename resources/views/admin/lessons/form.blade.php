<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ $lesson->exists ? 'Edit Lesson' : 'Add Lesson' }}: {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST"
                  action="{{ $lesson->exists ? route('admin.lessons.update', $lesson) : route('admin.courses.lessons.store', $course) }}"
                  class="bg-white p-6 shadow sm:rounded-lg space-y-4">
                @csrf
                @if ($lesson->exists) @method('PUT') @endif

                <div>
                    <x-input-label for="title" value="Lesson title *" />
                    <x-text-input id="title" name="title" class="block mt-1 w-full"
                                  :value="old('title', $lesson->title)" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="description" value="Description" />
                    <textarea id="description" name="description" rows="4"
                              class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $lesson->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                <div class="flex gap-3 pt-2">
                    <x-primary-button>Save</x-primary-button>
                    <a href="{{ route('admin.courses.lessons.index', $course) }}"
                       class="px-4 py-2 border rounded-md text-sm">Cancel</a>
                </div>
            </form>

            @if ($lesson->exists)
                <div class="bg-white p-6 shadow sm:rounded-lg mt-6">
                    <h3 class="font-semibold mb-2">Lesson video</h3>
                    <p class="text-sm text-gray-600 mb-3">
                        Status: <span class="font-medium">{{ $lesson->video?->status ?? 'belum ada video' }}</span>
                        @if ($lesson->video?->original_filename)
                            ({{ $lesson->video->original_filename }})
                        @endif
                    </p>

                    @if ($lesson->video?->status === 'ready')
                        <video controls class="w-full max-w-xl mb-4 rounded"
                               src="{{ route('videos.stream', $lesson->video) }}"></video>
                    @endif

                    <input type="file" id="video-file" accept="video/mp4,video/quicktime,video/webm" class="text-sm">
                    <button type="button" id="upload-btn" class="px-3 py-1.5 bg-gray-800 text-white text-sm rounded-md">Upload</button>
                    <button type="button" id="retry-btn" class="hidden px-3 py-1.5 border text-sm rounded-md">Retry</button>

                    <div id="progress-wrap" class="hidden mt-3 h-2 bg-gray-200 rounded">
                        <div id="progress-bar" class="h-2 bg-blue-600 rounded" style="width:0%"></div>
                    </div>
                    <p id="progress-text" class="text-sm mt-1"></p>
                    <p class="text-xs text-gray-500 mt-2">MP4, MOV, atau WebM. Maksimal 500 MB.</p>
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
                            text.textContent = 'Gagal: ' + msg;
                            text.className = 'text-sm mt-1 text-red-600';
                            uploadBtn.disabled = false;
                            retryBtn.classList.remove('hidden');
                        }

                        function upload(file) {
                            lastFile = file;
                            uploadBtn.disabled = true;
                            retryBtn.classList.add('hidden');
                            wrap.classList.remove('hidden');
                            bar.style.width = '0%';
                            text.className = 'text-sm mt-1 text-gray-700';
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
                                text.textContent = pct < 100 ? 'Uploading ' + pct + '%' : 'Memproses di server...';
                            };

                            xhr.onload = function () {
                                if (xhr.status >= 200 && xhr.status < 300) {
                                    text.textContent = 'Upload selesai. Status: ready';
                                    setTimeout(() => location.reload(), 800);
                                    return;
                                }
                                let msg = 'Terjadi kesalahan (' + xhr.status + ').';
                                try {
                                    const json = JSON.parse(xhr.responseText);
                                    msg = (json.errors && json.errors.video) ? json.errors.video[0] : (json.message || msg);
                                } catch (e) {}
                                fail(msg);
                            };

                            xhr.onerror = () => fail('Koneksi terputus.');
                            xhr.send(data);
                        }

                        uploadBtn.addEventListener('click', function () {
                            if (!input.files.length) { fail('Pilih file video dulu.'); return; }
                            upload(input.files[0]);
                        });
                        retryBtn.addEventListener('click', () => lastFile && upload(lastFile));
                    })();
                </script>
            @endif
        </div>
    </div>
</x-app-layout>