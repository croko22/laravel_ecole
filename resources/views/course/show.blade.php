<x-layout>
    <input type="text" class="block w-full mt-1 text-2xl font-bold bg-transparent border-none form-input"
        value="{{ $course->name }}">
    <textarea class="block w-full mt-1 form-textarea" rows="3">{{ $course->description }}</textarea>

    <h2 class="mt-4 text-xl font-bold">Teacher</h2>
    @foreach ($course->teachers as $teacher)
        <p class="mt-2">{{ $teacher->name }}, {{ $teacher->email }}</p>
    @endforeach

    <h2 class="mt-4 text-xl font-bold">Students</h2>
    @foreach ($course->students as $student)
        <p class="mt-2">{{ $student->name }}, {{ $student->lastname }}</p>
    @endforeach
</x-layout>
