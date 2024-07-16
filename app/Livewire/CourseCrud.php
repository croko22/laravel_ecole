<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Course;

#[Layout('components.layouts.app')]
class CourseCrud extends Component
{
    use WithPagination;

    public string $name;
    public string $description;
    public string $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $searchTerm = '%' . $this->query . '%';
        $user = User::find(auth()->user()->id);

        // if ($user->hasRole('admin')) {
        //     $courses = Course::where('name', 'like', $searchTerm)->orWhere('description', 'like', $searchTerm)
        //         ->orderBy('created_at', 'desc')
        //         ->paginate(9);
        // } else if ($user->hasRole('teacher')) {
        //     $courses = $user->courses()
        //         ->where(function ($query) use ($searchTerm) {
        //             $query->where('name', 'like', $searchTerm)
        //                 ->orWhere('description', 'like', $searchTerm);
        //         })
        //         ->orderBy('created_at', 'desc')
        //         ->paginate(9);
        // }

        $courses = Course::where('name', 'like', $searchTerm)->orWhere('description', 'like', $searchTerm)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('livewire.course-crud', [
            'courses' => $courses
        ]);
    }
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
        $this->dispatch('course-created', ['message' => 'Course created successfully!']);
        // $this->courses = Course::all()->sortByDesc('created_at');
        $this->resetPage();
    }

    public function deleteCourse(int $courseId)
    {
        Course::destroy($courseId);
        $this->dispatch('course-deleted', ['message' => 'Course deleted successfully!'])->self();
        // $this->courses = Course::all();
    }
}