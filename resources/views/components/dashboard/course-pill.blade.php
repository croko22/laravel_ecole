@php
    $colors = [
        'gradient-green',
        'gradient-red',
        'gradient-purple',
        'gradient-pink',
        'gradient-yellow',
        'gradient-orange',
        'gradient-teal',
    ];
@endphp
<a href="{{ route('course.show', $course) }}"
    class="p-4 px-5 mb-2 text-sm font-medium text-blue-100 text-center rounded-lg bg-gradient-to-r {{ $colors[$index % count($colors)] }}">
    {{ $course->name }}
</a>
