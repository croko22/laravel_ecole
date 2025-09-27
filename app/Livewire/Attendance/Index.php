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

    protected $rules = [
        'date' => 'required|date',
        'time' => 'required|date_format:H:i',
    ];

    public function mount($course)
    {
        $this->course = $course;
    }

    #[On("lesson-created")]
    public function render()
    {
        return view('livewire.attendance.index', [
            'lessons' => $this->course->lessons()->orderBy('date', 'desc')->paginate(11)
        ]);
    }

    public function createLesson()
    {
        $this->validate();

        try {
            $specificDate = $this->date . ' ' . $this->time;
            $this->course->lessons()->create([
                'date' => $specificDate,
            ]);

            $this->dispatch('lesson-created', ['message' => 'Lesson created successfully!']);
            $this->modalOpen = false;
            $this->reset(['date', 'time']);
        } catch (\Exception $e) {
            $this->dispatch('error', ['message' => 'Failed to create lesson: ' . $e->getMessage()]);
        }
    }

    public function deleteMarked()
    {
        if (empty($this->selectedRows)) {
            $this->dispatch('warning', ['message' => 'No lessons selected for deletion.']);
            return;
        }

        try {
            Lesson::destroy($this->selectedRows);
            $this->selectedRows = [];
            $this->dispatch('lesson-deleted', ['message' => 'Lessons deleted successfully!']);
        } catch (\Exception $e) {
            $this->dispatch('error', ['message' => 'Failed to delete lessons: ' . $e->getMessage()]);
        }
    }
}
