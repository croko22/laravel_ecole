<?php

namespace App\Livewire\Attendance;

use Livewire\Component;

class Index extends Component
{
    public $course;
    public $attendance = [];

    public function mount()
    {
        // $this->attendance = auth()->user()->courses->map(function ($course) {
        //     return [
        //         'course' => $course,
        //         'attendance' => $course->attendance->groupBy('date')
        //     ];
        // });
    }

    public function render()
    {
        return view('livewire.attendance.index', [
            // 'attendance' => $this->attendance
        ]);
    }
}
