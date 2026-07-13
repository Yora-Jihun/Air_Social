<?php

namespace App\Livewire\Newsfeed;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    /** @var array<int, array<string, mixed>> */
    public array $posts = [];

    public function mount(): void
    {
        // TODO: Replace with a real query for posts visible to the authenticated user,
        // e.g. posts from the user's companies / groups:
        // $this->posts = Post::query()
        //     ->whereIn('company_id', Auth::user()->companyIds())
        //     ->with('author')
        //     ->latest()
        //     ->get()
        //     ->toArray();
        // For now we return static placeholder data so the feed layout can be built.
        $this->posts = [
            [
                'id' => 1,
                'author' => 'Amara Okafor',
                'role' => 'Product Lead · Northwind Co.',
                'avatar' => null,
                'timestamp' => '2h',
                'visibility' => 'Public',
                'body' => "We just shipped the new onboarding flow and early signals look great — drop your feedback in the company group so we can iterate before the wider rollout. 🚀",
                'like_count' => 24,
                'love_count' => 12,
                'comment_count' => 5,
            ],
            [
                'id' => 2,
                'author' => 'Diego Marín',
                'role' => 'Engineer · Brightwave',
                'avatar' => null,
                'timestamp' => '5h',
                'visibility' => 'Private',
                'body' => 'Heads up: the staging cluster maintenance is scheduled for tonight at 23:00 UTC. Expect a ~10 minute read-only window for internal tools.',
                'like_count' => 8,
                'love_count' => 2,
                'comment_count' => 3,
            ],
            [
                'id' => 3,
                'author' => 'Priya Nair',
                'role' => 'Designer · Pixel & Co.',
                'avatar' => null,
                'timestamp' => '1d',
                'visibility' => 'Public',
                'body' => 'New design system tokens are live for everyone. Soft grays, a single blue primary, and rounded-xl surfaces across the board. Let’s keep it consistent!',
                'like_count' => 51,
                'love_count' => 33,
                'comment_count' => 14,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.newsfeed.index', [
            'username' => Auth::user()->name,
        ])->layout('layouts.newsfeed');
    }
}
