@props(['header' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LearnSpace</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#F5F8FC] text-[#162A4A] antialiased">
    <header class="border-b border-slate-100 bg-white">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6">
            <div class="flex items-center gap-8">
                <a href="{{ route('student.courses.index') }}" class="text-xl font-bold">📖 LearnSpace</a>
                <a href="{{ route('student.courses.index') }}"
                   class="hidden border-b-2 border-[#162A4A] py-5 text-sm font-semibold sm:block">Explore courses</a>
            </div>
            <div class="flex items-center gap-4 sm:gap-6">
                <div class="hidden text-right leading-tight sm:block">
                    <div class="text-sm font-semibold">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-slate-500">Student account</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm font-medium text-[#2F5C9E]">Sign out</button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6">
        @if ($header)
            <div class="mb-6">{{ $header }}</div>
        @endif
        {{ $slot }}
    </main>
</body>
</html>