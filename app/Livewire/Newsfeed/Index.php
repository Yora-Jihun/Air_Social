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
                'author' => 'Maria Cristina Reyes',
                'role' => 'Relationship Manager · BDO Unibank',
                'avatar' => null,
                'timestamp' => '2h',
                'visibility' => 'Public',
                'body' => 'We just launched the upgraded BDO Mobile Banking app with biometric login and instant fund transfers. Try it out and share your feedback so we can fine-tune the experience before the full rollout.',
                'like_count' => 24,
                'reactions' => ['like' => 15, 'heart' => 6, 'wow' => 3],
                'comment_count' => 5,
            ],
            [
                'id' => 2,
                'author' => 'Juan Miguel Santos',
                'role' => 'Software Engineer · UnionBank',
                'avatar' => null,
                'timestamp' => '5h',
                'visibility' => 'Private',
                'body' => 'Heads up: the core banking API migration is scheduled tonight from 11:00 PM to 1:00 AM. Expect a brief maintenance window on internal tools and the partner portal.',
                'like_count' => 8,
                'reactions' => ['like' => 5, 'heart' => 2, 'wow' => 1],
                'comment_count' => 3,
            ],
            [
                'id' => 3,
                'author' => 'Ana Marie Cruz',
                'role' => 'Branch Operations · Metrobank',
                'avatar' => null,
                'timestamp' => '1d',
                'visibility' => 'Public',
                'body' => 'Our new account opening process is now fully digital. Customers can complete KYC and receive their debit card within the same day. Salamat sa buong team sa tulong!',
                'like_count' => 51,
                'reactions' => ['like' => 30, 'heart' => 15, 'wow' => 6],
                'comment_count' => 14,
            ],
            [
                'id' => 4,
                'author' => 'Paolo Mendoza',
                'role' => 'Data Analyst · BPI',
                'avatar' => null,
                'timestamp' => '3h',
                'visibility' => 'Public',
                'body' => 'Monthly transaction volume hit a new record this quarter. Great work from the operations and risk teams for keeping everything stable during peak hours.',
                'like_count' => 18,
                'reactions' => ['like' => 10, 'heart' => 5, 'wow' => 3],
                'comment_count' => 7,
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
