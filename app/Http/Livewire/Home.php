<?php

namespace App\Http\Livewire;

use App\Http\Helpers\HarvestHelper;
use Livewire\Component;
use Native\Laravel\Facades\Window;

class Home extends Component
{

    public function goToLogs()
    {
        Window::open('logs')
            ->route('logs')
            ->width(800)
            ->height(800);
    }
    public function render()
    {
        return view('livewire.home');
    }
}
