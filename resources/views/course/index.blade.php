<x-layout>
    <h1>Courses</h1>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-row flex-wrap -m-4">
                @forelse ($courses as $course)
                    <x-course-card :course="$course" />
                @empty
                    <p>No available courses</p>
                @endforelse
            </div>
        </div>
    </section>
</x-layout>
