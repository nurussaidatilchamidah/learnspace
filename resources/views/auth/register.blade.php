<x-auth-split eyebrow="GET STARTED" title="Start your next chapter." subtitle="Create your LearnSpace student account.">

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium">Full name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                   autocomplete="name" placeholder="Your name"
                   class="mt-2 w-full rounded-lg border-slate-200 px-4 py-3 text-sm focus:border-[#2F5C9E] focus:ring-[#2F5C9E]">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                   autocomplete="username" placeholder="you@example.com"
                   class="mt-2 w-full rounded-lg border-slate-200 px-4 py-3 text-sm focus:border-[#2F5C9E] focus:ring-[#2F5C9E]">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium">Password</label>
            <div class="relative mt-2">
                <input id="password" name="password" type="password" required autocomplete="new-password"
                       class="w-full rounded-lg border-slate-200 px-4 py-3 pr-16 text-sm focus:border-[#2F5C9E] focus:ring-[#2F5C9E]">
                <button type="button" data-toggle-pw="password"
                        class="absolute inset-y-0 right-4 text-sm text-[#2F5C9E] font-medium">Show</button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium">Confirm password</label>
            <div class="relative mt-2">
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       autocomplete="new-password"
                       class="w-full rounded-lg border-slate-200 px-4 py-3 pr-16 text-sm focus:border-[#2F5C9E] focus:ring-[#2F5C9E]">
                <button type="button" data-toggle-pw="password_confirmation"
                        class="absolute inset-y-0 right-4 text-sm text-[#2F5C9E] font-medium">Show</button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button class="w-full rounded-lg bg-[#162A4A] py-3.5 text-sm font-semibold text-white hover:bg-[#1F3B63]">
            Create account
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-500">
        Already have an account?
        <a href="{{ route('login') }}" class="font-semibold text-[#2F5C9E]">Sign in</a>
    </p>
</x-auth-split>