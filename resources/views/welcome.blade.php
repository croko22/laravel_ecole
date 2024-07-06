<x-layout>
    <h1 class="text-red-400">bs idk why tailwind doesnt works at all</h1>
    @auth
        <p>Welcome, {{ Auth::user()->name }}!</p>
        <p>Your role(s):
            @foreach (Auth::user()->roles as $role)
                <span>{{ $role->name }}</span>
            @endforeach
        </p>
    @else
        <p>Welcome, guest!</p>
    @endauth
</x-layout>
