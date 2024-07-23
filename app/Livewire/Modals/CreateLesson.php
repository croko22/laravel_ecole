<?php

namespace App\Livewire\Modals;

use App\Models\Course;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateLesson extends Component
{
    public $course;
    #[Validate('required')]
    public $date = null;
    #[Validate('required')]
    public $time = null;
    public $modalOpen = false;


    #[On('lesson-created')]
    public function closeModal()
    {
        $this->modalOpen = false;
    }

    public function mount(Course $course)
    {
        $this->course = $course;
    }

    public function render()
    {
        return view('livewire.modals.create-lesson');
    }

    // public function createLesson()
    // {
    //     $specificDate = $this->date . ' ' . $this->time;
    //     $this->course->lessons()->create([
    //         'date' => $specificDate,
    //     ]);

    //     $this->dispatch('lesson-created', ['message' => 'Lesson created successfully!']);
    //     $this->modalOpen = false;
    //     $this->reset();
    // }
}
