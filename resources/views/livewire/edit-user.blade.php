<div>
    <x-toast event="user-updated" message="User updated successfully!" />

    <p class="w-64 mt-2 text-sm text-center text-gray-500">
        {{ $this->user->email }}, {{ $this->user->name }}
        {{ $this->email }}, {{ $this->name }}
    </p>

    <form class="mt-5" wire:submit.prevent="update">
        <div>
            <label class="block text-sm text-gray-700 capitalize dark:text-gray-200">User name</label>
            <input placeholder="John" type="text" wire:model.live="name" class="input">
            @error('name')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="email" class="block text-sm text-gray-700 capitalize dark:text-gray-200">User
                email</label>
            <input placeholder="Doe" type="text" wire:model.live="email" class="input">
            @error('email')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <p class="text-yellow-500" wire:dirty>You have unsaved changes!</p>
        <div class="flex justify-end mt-6">
            <button type="submit" class="button-primary">
                Update user
            </button>
        </div>
    </form>
</div>
