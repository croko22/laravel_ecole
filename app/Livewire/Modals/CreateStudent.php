<?php

namespace App\Livewire\Modals;

use App\Models\Student;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateStudent extends Component
{

    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $lastname;
    public $modalOpen = false;


    #[On('student-added')]
    public function closeModal()
    {
        $this->modalOpen = false;
    }

    public function render()
    {
        return view('livewire.modals.create-student');
    }

    public function createStudent()
    {
        $this->validate();
        Student::create($this->pull());

        $this->reset();
        $this->dispatch('student-added', ['message' => 'Student created successfully!']);
    }
}
