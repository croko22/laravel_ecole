<div>
    <button data-modal-target="attendance-modal-{{ $lesson->id }}"
        data-modal-toggle="attendance-modal-{{ $lesson->id }}"
        class="font-medium text-blue-600 dark:text-blue-500 hover:underline" type="button">
        Take attendance
    </button>

    <!-- Main modal -->
    <div id="attendance-modal-{{ $lesson->id }}" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-screen">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="mr-5 text-lg font-semibold text-gray-900 dark:text-white">
                        Take attendance
                    </h3>
                    <p>
                        {{ date('F j, Y, h:m', strtotime($lesson->date)) }}
                    </p>
                    <button type="button" class="button-close"
                        data-modal-toggle="attendance-modal-{{ $lesson->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <ul class="max-w-lg divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($course->students as $student)
                        <li class="pb-3 sm:pb-4">
                            <div class="flex items-center justify-between space-x-4 rtl:space-x-reverse">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full"
                                        src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png"
                                        alt="Student image">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $student->lastname }} {{ $student->name }}
                                    </p>
                                </div>
                                <div class="flex flex-row space-x-2">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox"
                                            {{ $attendance->contains('student_id', $student->id) ? 'checked' : '' }}
                                            wire:click="updateAttendance({{ $student->id }}, $event.target.checked)"
                                            class="sr-only peer">
                                        <div
                                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 ms-3 dark:text-gray-300">
                                            {{ $lesson->attendance->contains('student_id', $student->id) ? 'Present' : 'Absent' }}
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </li>

                    @empty
                        <li class="py-3 sm:py-4">
                            <div class="flex justify-center items center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    No students found
                                </p>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
