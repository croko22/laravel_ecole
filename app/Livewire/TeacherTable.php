<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class TeacherTable extends Component
{
    use WithPagination;

    public $query = '';
    public $selectedRows = [];

    public $name;
    public $email;

    public function search()
    {
        $this->resetPage();
    }


    public function render()
    {
        $teachers = User::role(['teacher', 'admin'])
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->query . '%')
                    ->orWhere('email', 'like', '%' . $this->query . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        return view('livewire.teacher-table', compact('teachers'));
    }

    public function deleteMarked()
    {
        if (empty($this->selectedRows)) {
            return;
        }
        User::destroy($this->selectedRows);
        $this->selectedRows = [];

        $this->dispatch('teacher-deleted', ['message' => 'Teachers deleted successfully!']);
    }

    public function createTeacher()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required | email',
        ]);

        $teacher = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt('password'),
        ]);
        $teacher->assignRole('teacher');

        $this->reset();
        $this->dispatch('teacher-added', ['message' => 'Teacher added successfully!']);
    }

}
