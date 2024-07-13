<?php

namespace App\Livewire\Modals;

use App\Models\Student;
use Livewire\Component;

class CreateStudent extends Component
{
    // public $name;
    // public $lastname;

    // public function createStudent()
    // {
    //     $this->validate([
    //         'name' => 'required',
    //         'lastname' => 'required',
    //     ]);

    //     Student::create([
    //         'name' => $this->name,
    //         'lastname' => $this->lastname,
    //     ]);

    //     $this->reset();
    // }



    public function render()
    {
        return view('livewire.modals.create-student');
    }
}
