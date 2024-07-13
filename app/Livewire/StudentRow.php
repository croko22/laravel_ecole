<?php

namespace App\Livewire;

use Livewire\Component;

class StudentRow extends Component
{
    public $student;

    public function mount($student)
    {
        $this->student = $student;
    }

    public function render()
    {
        return view('livewire.student-row', [
            'student' => $this->student
        ]);
    }
}
