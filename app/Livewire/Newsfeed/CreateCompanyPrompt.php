<?php

namespace App\Livewire\Newsfeed;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateCompanyPrompt extends Component
{
    public bool $show = true;

    public function mount(): void
    {
        // TODO: only show to users with zero or few companies:
        // $this->show = Auth::user()->companies()->count() < 1;
        $this->show = true;
    }

    public function render()
    {
        return view('livewire.newsfeed.create-company-prompt');
    }
}
