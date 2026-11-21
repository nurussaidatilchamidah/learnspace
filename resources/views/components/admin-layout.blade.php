@props(['header' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LearnSpace Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#F5F8FC] text-[#162A4A] antialiased" x-data="{ open: false }">

    {{-- Overlay untuk HP --}}
    <div x-show="open" x-cloak @click="open = false" class="fixed inset-0 z-30 bg-black/40 md:hidden"></div>

    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 z-40 flex w-60 flex-col bg-[#162A4A] px-4 py-6 text-white
                  transition-transform md:translate-x-0"
           :class="open ? 'translate-x-0' : '-translate-x-full'">
        <div class="px-2 text-xl font-bold">📖 LearnSpace</div>
        <div class="mt-8 px-2 text-[10px] tracking-widest text-white/50">ADMIN WORKSPACE</div>

        <nav class="mt-3 space-y-1 text-sm">
            <a href="{{ route('admin.courses.index') }}"
               class="block rounded-lg px-3 py-2.5 {{ request()->routeIs('admin.*') ? 'bg-[#2A4468] font-semibold' : 'text-white/70 hover:bg-white/5' }}">
                Courses
            </a>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button class="w-full rounded-lg px-3 py-2.5 text-left text-sm text-white/70 hover:bg-white/5">⇥ Sign out</button>
        </form>
    </aside>

    {{-- Konten --}}
    <div class="md:pl-60">
        <div class="flex h-16 items-center justify-between border-b border-slate-100 bg-white px-4 sm:px-8">
            <div class="flex items-center gap-3">
                <button @click="open = true" class="md:hidden rounded-lg border border-slate-200 px-3 py-1.5 text-lg leading-none" aria-label="Menu">☰</button>
                <span class="text-sm text-slate-500">Workspace</span>
            </div>
            <div class="text-right leading-tight">
                <div class="text-sm font-semibold">{{ auth()->user()->name }}</div>
                <div class="text-xs text-slate-500">Administrator</div>
            </div>
        </div>

        <main class="p-4 sm:p-8">
            @if ($header)
                <div class="mb-6">{{ $header }}</div>
            @endif
            {{ $slot }}
        </main>
    </div>

    <style>[x-cloak] { display: none !important; }</style>
</body>
</html>
