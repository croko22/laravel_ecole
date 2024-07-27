<?php

namespace App\Livewire\Modals;

use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditUser extends Component
{
    public $user;
    #[Validate('required')]
    public $name;
    #[Validate('required | email')]
    public $email;
    public $role;
    public $modalOpen = false;

    #[On('user-updated')]
    public function closeModal()
    {
        $this->modalOpen = false;
    }

    public function mount($user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()->name;
    }

    public function render()
    {
        return view('livewire.modals.edit-user');
    }

    public function updateUser()
    {
        $this->validate();
        $this->user->update($this->pull());
        $this->dispatch('user-updated', ['message' => 'user updated successfully!']);
    }

    public function toggleRole()
    {
        if ($this->user->roles->first()->name == 'admin') {
            $this->user->removeRole('admin');
            $this->user->assignRole('teacher');
        } else {
            $this->user->removeRole('teacher');
            $this->user->assignRole('admin');
        }
    }
}
