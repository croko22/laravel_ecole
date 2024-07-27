<tr>
    <td class="size-px whitespace-nowrap">
        <div class="py-3 ps-6">
            <label for="hs-at-with-checkboxes-1" class="flex">
                <input type="checkbox" wire:model="$parent.selectedRows" value="{{ $teacher->id }}" class="input-checkbox">
                <span class="sr-only">Checkbox</span>
            </label>
        </div>
    </td>
    <td class="size-px whitespace-nowrap">
        <div class="py-3 ps-6 lg:ps-3 xl:ps-0 pe-6">
            <div class="flex items-center gap-x-3">
                <img class="inline-block size-[38px] rounded-full"
                    src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png"
                    alt="Image Description">
                <div class="grow">
                    <span
                        class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $teacher->name }}</span>
                </div>
            </div>
        </div>
    </td>
    <td class="h-px w-72 whitespace-nowrap">
        <div class="px-6 py-3">
            <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $teacher->email }}</span>
        </div>
    </td>
    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-3">
            <span
                class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </svg>
                Active
            </span>
        </div>
    </td>
    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-3">
            <div class="flex items-center gap-x-3">
                <span class="text-xs text-gray-500 dark:text-neutral-500">
                    {{ $teacher->courses->count() }} courses
                </span>
            </div>
        </div>
    </td>
    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-3">
            <span class="text-sm text-gray-500 dark:text-neutral-500">
                {{ $teacher->created_at->diffForHumans() }}
            </span>
        </div>
    </td>

    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-1.5">
            <livewire:modals.edit-user :user="$teacher" />
        </div>
    </td>
</tr>
