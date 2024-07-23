<?php

namespace App\Livewire\Attendance;

use App\Models\Lesson;
use Livewire\Attributes\On;
use Livewire\Component;

#[On("lesson-created"), On("lesson-deleted")]
class Index extends Component
{
    public $course;
    public $lessons;
    public $date = null;
    public $time = "9:00";
    public $modalOpen = false;
    public $selectedRows = [];

    public function mount($course)
    {
        $this->course = $course;
        $this->lessons = $course->lessons->sortBy('date');
    }

    public function render()
    {
        return view('livewire.attendance.index', [
            'lessons' => $this->lessons,
        ]);
    }

    public function createLesson()
    {
        $specificDate = $this->date . ' ' . $this->time;
        $this->course->lessons()->create([
            'date' => $specificDate,
        ]);

        $this->dispatch('lesson-created', ['message' => 'Lesson created successfully!']);
        $this->modalOpen = false;
        // $this->reset();
    }

    public function deleteMarked()
    {
        if (empty($this->selectedRows)) {
            return;
        }
        Lesson::destroy($this->selectedRows);
        $this->selectedRows = [];

        $this->dispatch('lesson-deleted', ['message' => 'Lessons deleted successfully!']);
    }
}
