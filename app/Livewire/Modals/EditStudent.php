<?php

namespace App\Livewire\Modals;

use Livewire\Component;


class EditStudent extends Component
{
    public $student;
    public $name;
    public $lastname;

    public function mount($student)
    {
        $this->student = $student;
        $this->name = $student->name;
        $this->lastname = $student->lastname;
    }
    public function render()
    {
        return view('livewire.modals.edit-student', [
            'student' => $this->student

        ]);
    }

    public function updateStudent()
    {
        $this->validate([
            'name' => 'required',
            'lastname' => 'required',
        ]);

        $this->student->update([
            'name' => $this->name,
            'lastname' => $this->lastname,
        ]);

        $this->dispatchBrowserEvent('student-updated', ['message' => 'Student updated successfully!']);
    }
}
