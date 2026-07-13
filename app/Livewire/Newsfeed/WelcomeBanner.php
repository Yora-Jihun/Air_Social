<?php

namespace App\Livewire\Newsfeed;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WelcomeBanner extends Component
{
    public string $name = '';

    public function mount(): void
    {
        // TODO: derive "new user" state from the authenticated user, e.g.
        // Auth::user()->created_at->diffInDays(now()) < 7, to conditionally greet.
        $this->name = Auth::user()?->name ?? 'there';
    }

    public function render()
    {
        return view('livewire.newsfeed.welcome-banner');
    }
}
