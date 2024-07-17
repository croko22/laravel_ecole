<div class="container">
    <x-toast event="course-created" message="Course created successfully!" />
    <x-toast event="course-deleted" message="Course deleted successfully!" />

    <div class="flex items-center justify-between mb-5">
        @can('create course')
            <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                class="flex flex-row items-center justify-center gap-2 button-primary " type="button">
                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg>
                Create course

            </button>
            <div id="default-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-2xl max-h-full p-4">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Create course
                            </h3>
                            <button type="button"
                                class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="default-modal">
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
                            <form>
                                <div class="form-group">
                                    <label for="name" class="label">Course Name:</label>
                                    <input wire:model="name" type="text" class="input" id="name">
                                    @error('name')
                                        <span class="invalid-feedback">{{ $description }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description" class="label">Course Description:</label>
                                    <x-tinymce wire:model="description" x-ref="description" :description="$description" />
                                    @error('description')
                                        <span class="invalid-feedback">{{ $description }}</span>
                                    @enderror
                                </div>

                                <button class="button-primary" wire:click="createCourse">Add
                                    Course</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        <x-search :query="$query" />
    </div>

    <section class="mt-5 text-gray-600 body-font">
        <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($courses as $course)
                <livewire:course-card :course="$course" wire:key="course-{{ $course->id }}" />
            @empty
                <p>No available courses</p>
            @endforelse
        </div>

    </section>
    {{ $courses->links() }}
</div>
