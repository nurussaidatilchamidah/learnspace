<x-auth-split eyebrow="WELCOME BACK" title="Your next chapter awaits." subtitle="Sign in to your LearnSpace account.">

    @if (session('status'))
        <div class="mt-6 rounded-lg bg-[#E6F2EA] px-4 py-3 text-sm text-[#2E6B4A]">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                   autocomplete="username" placeholder="you@example.com"
                   class="mt-2 w-full rounded-lg border-slate-200 px-4 py-2.5 text-sm focus:border-[#2F5C9E] focus:ring-[#2F5C9E]">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium">Password</label>
            <div class="relative mt-2">
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       class="w-full rounded-lg border-slate-200 px-4 py-2.5 pr-16 text-sm focus:border-[#2F5C9E] focus:ring-[#2F5C9E]">
                <button type="button" data-toggle-pw="password"
                        class="absolute inset-y-0 right-4 text-sm text-[#2F5C9E] font-medium">Show</button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
            <label class="flex items-center gap-2 text-slate-600">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-[#162A4A] focus:ring-[#162A4A]">
                Remember me
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="font-medium text-[#2F5C9E]">Forgot password?</a>
            @endif
        </div>

        <button class="w-full rounded-lg bg-[#162A4A] py-3 text-sm font-semibold text-white hover:bg-[#1F3B63]">
            Sign in
        </button>
    </form>

    @if (Route::has('register'))
        <p class="mt-6 text-center text-sm text-slate-500">
            New to LearnSpace?
            <a href="{{ route('register') }}" class="font-semibold text-[#2F5C9E]">Create an account</a>
        </p>
    @endif
</x-auth-split>