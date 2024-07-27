<?php

namespace App\Livewire\Modals;

use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditStudent extends Component
{

    public $student;
    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $lastname;
    public $modalOpen = false;

    #[On('student-updated')]
    public function closeModal()
    {
        $this->modalOpen = false;
    }

    public function mount($student)
    {
        $this->student = $student;
        $this->name = $student->name;
        $this->lastname = $student->lastname;
    }
    public function render()
    {
        return view('livewire.modals.edit-student');
    }

    public function updateStudent()
    {
        $this->validate();
        $this->student->update($this->pull());
        $this->dispatch('student-updated', ['message' => 'Student updated successfully!']);
    }
}
