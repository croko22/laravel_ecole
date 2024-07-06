<x-layout>
    <h1>LARA MOVIES</h1>

    {{-- @if (session('success'))
        <x-toast />
    @endif

    @if (session('error'))
        <x-error />
    @endif --}}

    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Login</h2>
    <form class="max-w-sm mx-auto" action={{ route('login') }} method="POST">
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
        <button type="submit" class="submit">Submit</button>
    </form>

</x-layout>
