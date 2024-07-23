<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

#[On("attendance-updated")]
class LessonRow extends Component
{
    public $lesson;
    public $course;

    public function mount($lesson, $course)
    {
        $this->lesson = $lesson;
        $this->course = $course;
    }
    public function render()
    {
        return view('livewire.lesson-row', ['lesson' => $this->lesson]);
    }
}
