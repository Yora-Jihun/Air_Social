<?php

namespace App\Livewire\Newsfeed;

use Livewire\Component;

class PeopleYouMayKnowWidget extends Component
{
    /** @var array<int, array<string, mixed>> */
    public array $people = [];

    public function mount(): void
    {
        // TODO: replace with real suggestions:
        // $this->people = User::query()
        //     ->whereNotIn('id', Auth::user()->connectedIds())
        //     ->where('id', '<>', Auth::id())
        //     ->inRandomOrder()
        //     ->limit(5)
        //     ->get(['id', 'name', 'title'])
        //     ->toArray();
        $this->people = [
            ['name' => 'Liam Chen', 'role' => 'Designer at Pixel & Co.', 'avatar' => null],
            ['name' => 'Sofia Rossi', 'role' => 'Engineer at Brightwave', 'avatar' => null],
            ['name' => 'Marcus Lee', 'role' => 'PM at Northwind Co.', 'avatar' => null],
        ];
    }

    public function render()
    {
        return view('livewire.newsfeed.people-you-may-know-widget');
    }
}
