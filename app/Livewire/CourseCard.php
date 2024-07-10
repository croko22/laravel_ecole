<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class CourseCard extends Component
{
    public $course;

    public function mount($course)
    {
        $this->course = $course;
    }
    public function render()
    {
        return view('livewire.course-card', [
            'course' => $this->course
        ]);
    }
}
