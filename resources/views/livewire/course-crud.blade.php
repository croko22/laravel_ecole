<div class="container">
    <x-toast event="course-created" message="Course created successfully!" />
    <x-toast event="course-deleted" message="Course deleted successfully!" />

    <div class="flex items-center justify-between mb-5">

        @can('create course')
            <livewire:modals.create-course />
        @endcan

        <x-search :query="$query" placeholder="Search courses..." />
    </div>

    <section class="mt-5 text-gray-600 body-font">
        <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($courses as $course)
                <livewire:course-card :course="$course" wire:key="course-{{ $course->id }}" />
            @empty
                <p>No available courses</p>
            @endforelse
        </div>
        {{ $courses->links() }}
    </section>
</div>
