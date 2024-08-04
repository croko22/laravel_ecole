<div x-data="{ modalOpen: $wire.entangle('modalOpen') }">
    <button @click="modalOpen =!modalOpen"
        class="inline-flex items-center text-sm font-medium text-blue-600 gap-x-1 decoration-2 hover:underline dark:text-blue-500">
        Edit
    </button>

    <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
            <div x-cloak @click="modalOpen = false" x-show="modalOpen"
                x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

            <div x-cloak x-show="modalOpen" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="modal">
                <div class="flex items-center justify-between space-x-4">
                    <h1 class="text-xl font-medium text-gray-800 ">Edit student</h1>

                    <button @click="modalOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>

                <p class="mt-2 text-sm text-gray-500 ">
                    Edit the student information.
                </p>

                <form class="mt-5" wire:submit.prevent="updateStudent">
                    <div>
                        <label class="block text-sm text-gray-700 capitalize dark:text-gray-200">Student name</label>
                        <input placeholder="John" type="text" wire:model="name" class="input">
                        @error('name')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="lastname" class="block text-sm text-gray-700 capitalize dark:text-gray-200">Student
                            lastname</label>
                        <input placeholder="Doe" type="text" wire:model="lastname" class="input">
                        @error('lastname')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <p class="text-yellow-500" wire:dirty>You have unsaved changes!</p>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="button-primary">
                            Update student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
