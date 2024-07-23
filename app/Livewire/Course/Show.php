<?php

namespace App\Livewire\Course;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public Course $course;
    public $name;
    public $description;
    public $teachers;
    public $selectedTeacher;
    public $students;
    public $selectedNewStudent;

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->name = $course->name;
        $this->description = $course->description;
        $this->teachers = User::teachers()->get() ?? [];
        $this->selectedTeacher = $this->course->teachers->first()->id ?? null;
        $this->students = Student::all();
    }

    public function render()
    {
        return view('livewire.course.show', [
            'course' => $this->course,
            'teachers' => $this->teachers,
            'students' => $this->students,
        ]);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $this->course->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->course->teachers()->sync($this->selectedTeacher);

        $this->dispatch('course-updated', ['message' => 'Course updated successfully!']);

    }

    public function addStudent()
    {
        $this->validate([
            'selectedNewStudent' => 'required',
        ]);

        $this->course->students()->attach($this->selectedNewStudent);
        $this->dispatch('course-updated', ['message' => 'Student added successfully!']);
    }

    public function removeStudent($studentId)
    {
        $this->course->students()->detach($studentId);
        $this->course = Course::find($this->course->id);
    }
}
