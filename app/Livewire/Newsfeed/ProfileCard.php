<?php

namespace App\Livewire\Newsfeed;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfileCard extends Component
{
    public string $name = '';

    public ?string $avatar = null;

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user?->name ?? 'Guest';
        // TODO: $this->avatar = $user->avatar_url when avatars exist.
        $this->avatar = null;
    }

    public function render()
    {
        return view('livewire.newsfeed.profile-card');
    }
}
