<?php

namespace App\Livewire\Modals;

use App\Models\Course;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateCourse extends Component
{
    #[Validate('required')]
    public string $name;
    #[Validate('required')]
    public string $description;
    public bool $modalOpen = false;

    #[On('course-created')]
    public function closeModal()
    {
        $this->modalOpen = false;
    }

    public function render()
    {
        return view('livewire.modals.create-course');
    }

    public function createCourse()
    {
        $this->validate();
        Course::create($this->pull());
        $this->reset();
        $this->description = '';
        $this->dispatch('course-created', ['message' => 'Course created successfully!']);
    }
}
