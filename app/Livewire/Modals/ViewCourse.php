<?php

namespace App\Livewire\Modals;

use Livewire\Component;

class ViewCourse extends Component
{
    public $course;

    public function mount($course)
    {
        $this->course = $course;
    }

    public function render()
    {
        return view('livewire.modals.view-course', [
            'course' => $this->course
        ]);
    }
}
