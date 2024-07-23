<?php

namespace App\Livewire\Attendance;

use App\Models\Course;
use App\Models\Lesson;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $course;
    public $date = null;
    public $time = "9:00";
    public $modalOpen = false;
    public $selectedRows = [];

    public function mount($course)
    {
        $this->course = $course;
    }

    #[On("lesson-created")]
    public function render()
    {
        return view('livewire.attendance.index', [
            'lessons' => Course::find($this->course->id)->lessons()->paginate(11),
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
