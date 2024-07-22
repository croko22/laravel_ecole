<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Course;

#[On('course-created')]
#[Layout('components.layouts.app')]
class CourseCrud extends Component
{
    use WithPagination;
    public string $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $searchTerm = '%' . $this->query . '%';
        $user = User::find(auth()->user()->id);

        $query = Course::query();

        if ($user->hasRole('admin')) {
            $query->where('name', 'like', $searchTerm)
                ->orWhere('description', 'like', $searchTerm);
        } elseif ($user->hasRole('teacher')) {
            $query = $user->courses()->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm);
            });
        }

        $courses = $query->orderBy('created_at', 'desc')->paginate(9);

        return view('livewire.course-crud', compact('courses'));
    }

    public function deleteCourse(int $courseId)
    {
        Course::destroy($courseId);
        $this->dispatch('course-deleted', ['message' => 'Course deleted successfully!'])->self();
    }
}