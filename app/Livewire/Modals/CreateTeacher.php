<?php

namespace App\Livewire\Modals;

use Livewire\Attributes\On;
use Livewire\Component;

class CreateTeacher extends Component
{
    public $modalOpen = false;


    #[On('teacher-added')]
    public function closeModal()
    {
        $this->modalOpen = false;
    }
    public function render()
    {
        return view('livewire.modals.create-teacher');
    }
}
