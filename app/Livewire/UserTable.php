<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class UserTable extends Component
{
    public function render()
    {
        return view('livewire.user-table');
    }
}
