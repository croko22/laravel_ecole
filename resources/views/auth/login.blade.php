<x-guest-layout>
    @if (session('error'))
        <div class="absolute top-10 left-10 ">
            <x-error />
        </div>
    @endif

    {{-- @if (session('success'))
        <x-toast />
    @endif
    --}}

    <h2 class="text-2xl font-semibold text-center text-gray-900 dark:text-white">Login</h2>
    <form class="flex flex-col max-w-sm gap-5 mx-auto" action={{ route('login') }} method="POST">
        @csrf
        <div class="mb-5">
            <label for="email" class="label">Your email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="input"
                placeholder="john@doe.com" />
            @error('email')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-5">
            <label for="password" class="label">Your
                password</label>
            <input type="password" id="password" name="password" class="input" required />
            @error('password')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <a href={{ route('password.request') }} class="link">Forgot your password?</a>
        <button type="submit" class="button-primary">Submit</button>
    </form>

</x-guest-layout>
