<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

#[Layout('components.layouts.app')]

#[On('student-added')]
class StudentTable extends Component
{
    use WithPagination;

    public $query = '';
    public $selectedRows = [];

    #[Validate('required')]
    public $name;
    public $lastname;

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = Student::orderBy('updated_at', 'desc')->
            where('name', 'like', '%' . $this->query . '%')->
            orWhere('lastname', 'like', '%' . $this->query . '%')->
            paginate(10);
        return view('livewire.student-table', compact('students'));
    }

    public function deleteMarked()
    {
        if (empty($this->selectedRows)) {
            return;
        }
        Student::destroy($this->selectedRows);
        $this->selectedRows = [];

        $this->dispatch('student-deleted', ['message' => 'Students deleted successfully!']);
    }

    public function createStudent()
    {
        $this->validate([
            'name' => 'required',
            'lastname' => 'required',
        ]);

        Student::create([
            'name' => $this->name,
            'lastname' => $this->lastname,
        ]);

        $this->reset();
        $this->dispatch('student-added', ['message' => 'Student added successfully!']);
    }
}
