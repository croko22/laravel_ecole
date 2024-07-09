<x-layout>
    <h1>{{ $course->name }}</h1>
    <p>{{ $course->description }}</p>

    @foreach ($course->students as $student)
        <p>{{ $student->name }}, {{ $student->lastname }}</p>
    @endforeach

</x-layout>
