<x-layout>
    @can('edit course')
        <input placeholder="Static" value="{{ $course->name }}"
            class="text-2xl font-bold peer h-full w-full border-b border-gray-900 bg-transparent pt-4 pb-1.5 font-sans text-blue-gray-700 outline outline-0 transition-all placeholder-shown:border-blue-gray-200 focus:border-gray-900 focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50" />

        <textarea class="block w-full mt-4 form-textarea" rows="3">{{ $course->description }}</textarea>
    @endcan


    <h1 class="text-6xl font-extrabold dark:text-white">Course: <small
            class="font-semibold text-gray-500 ms-2 dark:text-gray-400">{{ $course->name }}</small></h1>
    <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">{{ $course->description }}</p>

    <h2 class="mt-4 text-xl font-bold">Teacher</h2>
    @foreach ($course->teachers as $teacher)
        <p class="mt-2">{{ $teacher->name }}, {{ $teacher->email }}</p>
    @endforeach

    <h2 class="mt-4 text-xl font-bold">Students</h2>
    @foreach ($course->students as $student)
        <p class="mt-2">{{ $student->name }}, {{ $student->lastname }}</p>
    @endforeach

    @can('take attendance')
        @livewire('attendance', ['course' => $course])
    @endcan
</x-layout>
