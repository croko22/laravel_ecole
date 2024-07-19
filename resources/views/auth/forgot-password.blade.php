<x-layouts.layout>

    <h1>Enter your email</h1>

    <form class="max-w-sm mx-auto" action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="mb-5">
            <label for="email" class="label">Your email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="input"
                placeholder="john@doe.com" />
            @error('email')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="button-primary">Submit</button>
    </form>
</x-layouts.layout>
