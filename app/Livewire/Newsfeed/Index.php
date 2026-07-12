<?php

namespace App\Livewire\Newsfeed;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.newsfeed.index', [
            'username' => Auth::user()->name,
        ])->layout('layouts.newsfeed');
    }
}