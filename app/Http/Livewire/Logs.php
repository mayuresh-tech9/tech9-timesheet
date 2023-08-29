<?php

namespace App\Http\Livewire;

use App\Http\Helpers\HarvestHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Logs extends Component
{
    public $data;
    public $showDetails = false;

    public function mount()
    {
        $this->data = HarvestHelper::getLogs();

    }
    public function toggleDetails()
    {
        $this->showDetails = !$this->showDetails;
    }

    public function render()
    {
        return view('livewire.logs', [
            'data' => $this->data,
        ]);
    }


}
