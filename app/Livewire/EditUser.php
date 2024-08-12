<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Edit User Profile')]
#[Layout('components.layouts.app')]
class EditUser extends Component
{
    #[Validate('required', 'string', 'max:255')]
    public $name;
    #[Validate('required', 'string', 'email', 'max:255')]
    public $email;

    #[Computed]
    public function user()
    {
        return auth()->user();
    }

    public function mount()
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    public function render()
    {
        return view('livewire.edit-user');
    }

    public function update()
    {
        $this->validate();
        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->dispatch('user-updated', ['message' => 'User updated successfully!']);
    }
}
