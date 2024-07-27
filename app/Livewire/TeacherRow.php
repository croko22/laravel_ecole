<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

#[On('user-updated')]
class TeacherRow extends Component
{
    public $teacher;

    public function mount($teacher)
    {
        $this->teacher = $teacher;
    }
    public function render()
    {
        return view('livewire.teacher-row', [
            'teacher' => $this->teacher
        ]);
    }
}
