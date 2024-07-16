<div class="course-card">
    <div class="course-card__content">
        <img class="course-card__image"
            src="https://img.freepik.com/vector-gratis/fondo-linea-elegante-hexagonal-patron_1017-19742.jpg?size=626&ext=jpg&ga=GA1.1.539837299.1711756800&semt=ais"
            alt="Course image" />

        <h5 class="course-card__title">{{ $course->name }}</h5>
        <p class="course-card__description">{{ $course->description }}</p>

        <div class="course-card__view-link">
            {{-- MODAL --}}
            <button data-modal-target="modal-{{ $course->id }}" data-modal-toggle="modal-{{ $course->id }}"
                class="button-primary" type="button">
                View Course
            </button>
        </div>
        <!-- Main modal -->
        <div id="modal-{{ $course->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full p-4">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ $course->name }}
                        </h3>
                        <button type="button" class="button-close" data-modal-hide="modal-{{ $course->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 space-y-4 md:p-5">
                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                            {{ $course->description }}
                        </p>
                        {{-- TEACHER --}}
                        <h3 class="mb-2 text-lg font-semibold">Teachers</h3>
                        <ul class="pl-5 list-disc">
                            @forelse ($course->teachers as $teacher)
                                <li class="text-sm text-gray-700">{{ $teacher->name }}</li>
                            @empty
                                <li class="text-sm text-gray-700">No teachers</li>
                            @endforelse
                        </ul>

                        {{-- STUDENTS --}}
                        <h3 class="mb-2 text-lg font-semibold">Students</h3>
                        <ul class="pl-5 list-disc">
                            @forelse ($course->students->take(10) as $index => $student)
                                <li class="text-sm text-gray-700">{{ $student->name }}, {{ $student->lastname }}</li>
                                @if ($index === 9 && $course->students->count() > 10)
                                    <li class="text-sm text-gray-700">...</li>
                                @endif
                            @empty
                                <li class="text-sm text-gray-700">No students</li>
                            @endforelse
                        </ul>
                    </div>


                    <!-- Modal footer -->
                    <div class="flex items-center p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">
                        @can('edit course')
                            <a data-modal-hide="modal-{{ $course->id }}" href="{{ route('course.show', $course) }}"
                                class="button-primary">Edit</a>
                            <button data-modal-hide="modal-{{ $course->id }}" type="button"
                                wire:click="$parent.deleteCourse({{ $course->id }})"
                                wire:confirm="Are you sure you want to delete this course?"
                                class="ml-2 button-danger">Delete</button>
                        @endcan
                        @can('take attendance')
                            <a data-modal-hide="modal-{{ $course->id }}" href="{{ route('course.show', $course) }}"
                                class="button-primary">View course</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>


        <div class="course-card__stats">
            <span class="course-card__stats-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                {{ $course->students_count() }}
            </span>
        </div>
    </div>
</div>
