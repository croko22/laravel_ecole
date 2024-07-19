<x-layouts.layout>
    <div class="w-screen max-w-screen-xl">
        <h1>Dashboard</h1>
        <div class="p-4 space-y-4 sm:p-6 sm:space-y-6">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 sm:gap-6">
                <x-dashboard.header-card label="Welcome" :value="auth()->user()->name" />
                <x-dashboard.header-card label="Total courses" :value="$coursesCount" />
                <x-dashboard.header-card label="Total students" :value="$studentsCount" />
                <x-dashboard.header-card label="Total teachers" :value="$teachersCount" />
            </div>

            <div class="grid gap-4 lg:grid-cols-2 sm:gap-6">
                <!-- Card -->
                <div
                    class="p-4 md:p-5 min-h-[410px] flex flex-col  gap-3 bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-sm text-gray-500 dark:text-neutral-500">
                                Courses
                            </h2>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($courses as $index => $course)
                            <x-dashboard.course-pill :course="$course" :index="$index" />
                        @endforeach
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div
                    class="p-4 md:p-5 min-h-[410px] flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <!-- Header -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-sm text-gray-500 dark:text-neutral-500">
                                Teachers
                            </h2>
                        </div>
                    </div>
                    <!-- End Header -->

                    <div>
                        <ul class="divide-y divide-gray-200 dark:divide-neutral-600">
                            @foreach ($teachers as $teacher)
                                <li class="flex justify-between py-3 items center">
                                    <div class="flex gap-3 items center">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png"
                                            alt="{{ $teacher->name }}" class="w-8 h-8 rounded-full">
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-800 dark:text-neutral-200">
                                                {{ $teacher->name }}
                                            </h3>
                                            <p class="text-xs text-gray-500 dark:text-neutral-500">
                                                {{ $teacher->email }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.layout>
