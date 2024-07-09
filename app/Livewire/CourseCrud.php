<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Course;

class CourseCrud extends Component
{
    use WithPagination;

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.course-crud', [
            'courses' => Course::orderBy('created_at', 'desc')->paginate(9),
        ]);
    }

    public $name;
    public $description;
    public $selectedCourseId;

    public function createCourse()
    {
        $this->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        Course::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->reset();
        $this->courses = Course::all()->sortByDesc('created_at');
    }

    public function editCourse(int $courseId)
    {
        $this->selectedCourseId = $courseId;
        $course = Course::find($courseId);
        $this->name = $course->name;
        $this->description = $course->description;
    }

    public function updateCourse()
    {
        $this->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $course = Course::find($this->selectedCourseId);
        $course->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->selectedCourseId = null; // Clear selection after update
        $this->courses = Course::all(); // Refresh course list after update
    }

    public function deleteCourse(int $courseId)
    {
        Course::find($courseId)->delete();
        $this->courses = Course::all(); // Refresh course list after deletion
    }
}