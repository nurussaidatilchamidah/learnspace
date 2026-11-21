@props(['eyebrow' => '', 'title' => '', 'subtitle' => ''])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - LearnSpace</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="antialiased text-[#162A4A]">
<div class="min-h-screen lg:h-screen lg:overflow-hidden grid lg:grid-cols-2">

    {{-- Panel kiri: hanya tampil di layar besar, tidak ikut scroll --}}
    <div class="hidden lg:flex flex-col justify-between gap-6 bg-[#162A4A] text-white p-10 xl:px-14 xl:py-12 overflow-hidden">
        <div class="text-2xl font-bold">📖 LearnSpace</div>

        <div>
            <h1 class="text-4xl xl:text-5xl font-bold leading-tight">A little progress.<br>A world of possibility.</h1>
            <p class="mt-5 text-white/70">Build skills that move you forward.<br>Your next chapter starts here.</p>

            {{-- Kartu grafik disembunyikan kalau layar pendek (tinggi < 760px) --}}
            <div class="mt-10 rounded-3xl bg-[#1F3B63] p-6 max-w-md [@media(max-height:760px)]:hidden">
                <div class="text-[11px] tracking-wide text-white/60">YOUR LEARNING JOURNEY</div>
                <div class="mt-2 text-xl font-semibold">Make room for what’s next.</div>
                <div class="mt-6 flex items-end justify-between h-32">
                    @foreach ([40, 62, 48, 80, 70, 100, 120] as $h)
                        <div class="w-8 rounded-md {{ $loop->last ? 'bg-white' : 'bg-[#6C86AB]' }}" style="height: {{ $h }}px"></div>
                    @endforeach
                </div>
                <div class="mt-3 flex justify-between text-[11px] text-white/60">
                    @foreach (['M','T','W','T','F','S','S'] as $d)
                        <span class="w-8 text-center">{{ $d }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-sm text-white/70">Learn at your pace. Grow on your terms.</div>
    </div>

    {{-- Panel kanan: kalau form terlalu tinggi, hanya bagian ini yang scroll --}}
    <div class="flex flex-col bg-white px-5 sm:px-8 py-4 lg:overflow-y-auto">
        <div class="lg:hidden text-xl font-bold">📖 LearnSpace</div>

        <div class="flex flex-1 items-center justify-center">
            <div class="w-full max-w-md py-2">
                <div class="text-xs font-semibold tracking-wide text-[#2F5C9E]">{{ $eyebrow }}</div>
                <h2 class="mt-2 text-3xl 2xl:text-4xl font-bold">{{ $title }}</h2>
                <p class="mt-2 text-slate-500">{{ $subtitle }}</p>

                {{ $slot }}
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('[data-toggle-pw]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = document.getElementById(btn.dataset.togglePw);
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.textContent = show ? 'Hide' : 'Show';
        });
    });
</script>
</body>
</html>