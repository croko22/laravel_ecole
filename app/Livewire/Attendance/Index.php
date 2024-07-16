<?php

namespace App\Livewire\Attendance;

use Livewire\Component;

class Index extends Component
{
    public $course;
    public $lessons;
    public $date = null;

    public function mount($course)
    {
        $this->course = $course;
        $this->lessons = $course->lessons;
    }

    public function render()
    {
        return view('livewire.attendance.index', [
            'lessons' => $this->lessons,
        ]);
    }

    public function createLesson()
    {
        $this->course->lessons()->create([
            'date' => now(),
        ]);

        $this->dispatch('lesson-created', ['message' => 'Lesson created successfully!']);
    }
}
