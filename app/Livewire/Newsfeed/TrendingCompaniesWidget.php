<?php

namespace App\Livewire\Newsfeed;

use Livewire\Component;

class TrendingCompaniesWidget extends Component
{
    /** @var array<int, array<string, mixed>> */
    public array $companies = [];

    public function mount(): void
    {
        // TODO: replace with real trending public companies:
        // $this->companies = Company::query()
        //     ->where('visibility', 'public')
        //     ->orderByDesc('members_count')
        //     ->limit(5)
        //     ->get(['name', 'members_count', 'avatar_url'])
        //     ->toArray();
        $this->companies = [
            ['name' => 'BDO Unibank', 'members' => 1280, 'avatar' => null],
            ['name' => 'Metrobank', 'members' => 940, 'avatar' => null],
            ['name' => 'BPI', 'members' => 712, 'avatar' => null],
            ['name' => 'UnionBank', 'members' => 503, 'avatar' => null],
        ];
    }

    public function render()
    {
        return view('livewire.newsfeed.trending-companies-widget');
    }
}
