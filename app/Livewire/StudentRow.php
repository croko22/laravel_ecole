<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

#[On("student-updated")]
class StudentRow extends Component
{
    public $student;
    public function render()
    {
        return view('livewire.student-row', [
            'student' => $this->student
        ]);
    }
}
