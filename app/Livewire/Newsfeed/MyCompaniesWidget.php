<?php

namespace App\Livewire\Newsfeed;

use Livewire\Component;

class MyCompaniesWidget extends Component
{
    /** @var array<int, array<string, mixed>> */
    public array $companies = [];

    public function mount(): void
    {
        // TODO: replace with the authenticated user's company memberships:
        // $this->companies = Auth::user()
        //     ->companies()
        //     ->withPivot('role')
        //     ->get()
        //     ->map(fn ($c) => ['name' => $c->name, 'role' => $c->pivot->role, 'avatar' => $c->avatar_url])
        //     ->toArray();
        $this->companies = [
            ['name' => 'BDO Unibank', 'role' => 'Admin', 'avatar' => null],
            ['name' => 'BPI', 'role' => 'Employee', 'avatar' => null],
        ];
    }

    public function render()
    {
        return view('livewire.newsfeed.my-companies-widget');
    }
}
