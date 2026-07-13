<?php

namespace App\Livewire\Newsfeed;

use Livewire\Attributes\Locked;
use Livewire\Component;

class PostCard extends Component
{
    #[Locked]
    public array $post = [];

    public bool $liked = false;

    public int $likeCount = 0;

    public int $commentCount = 0;

    // Reaction state: '' (none) | 'like' | 'heart' | 'wow'.
    // Each maps to an image asset in public/images — no SVG / emoji glyphs.
    public string $reaction = '';

    // Per-type counts from other people (the reaction summary bar).
    // Stubbed for now; will come from a reactions pivot/aggregate later.
    public array $reactions = [];

    private int $baseLikeCount = 0;

    public function mount(array $post): void
    {
        $this->post = $post;
        $this->commentCount = (int) ($post['comment_count'] ?? 0);
        $this->baseLikeCount = (int) ($post['like_count'] ?? 0);
        $this->reaction = ($post['liked'] ?? false) ? 'like' : '';
        $this->liked = $this->reaction !== '';
        $this->likeCount = $this->baseLikeCount + ($this->reaction === '' ? 0 : 1);
        $this->reactions = $post['reactions'] ?? ['like' => 12, 'heart' => 7, 'wow' => 5];
    }

    // NOTE: counts are stubbed in-memory only — no persistence yet.
    // When a posts table exists, sync these back via the model / pivot here.

    // Tap cycles through the three reactions: none → like → love → wow → none.
    public function cycleReaction(): void
    {
        $order = ['', 'like', 'heart', 'wow'];
        $index = array_search($this->reaction, $order, true);
        $this->reaction = $order[($index + 1) % count($order)];
        $this->syncReaction();
    }

    private function syncReaction(): void
    {
        $this->liked = $this->reaction !== '';
        $this->likeCount = $this->baseLikeCount + ($this->reaction === '' ? 0 : 1);
    }

    // Reaction glyphs are rendered as image assets (like / heart / wow)
    // from public/images so the bar reads like a real social feed.
    public function reactionImage(): string
    {
        return match ($this->reaction) {
            'heart' => asset('images/heart-reaction.png'),
            'wow'   => asset('images/wow-reaction.png'),
            default => asset('images/like-reaction.png'),
        };
    }

    public function reactionLabel(): string
    {
        return match ($this->reaction) {
            'heart' => 'Love',
            'wow'   => 'Wow',
            default => 'Like',
        };
    }

    // Distinct reaction types that have at least one count, for the summary.
    // Includes the current user's own reaction so the mix stays accurate.
    public function reactionSummary(): array
    {
        $counts = $this->reactions;
        if ($this->reaction !== '') {
            $counts[$this->reaction] = ($counts[$this->reaction] ?? 0) + 1;
        }

        $all = [
            'like'  => ['src' => asset('images/like-reaction.png'), 'label' => 'Like'],
            'heart' => ['src' => asset('images/heart-reaction.png'), 'label' => 'Love'],
            'wow'   => ['src' => asset('images/wow-reaction.png'), 'label' => 'Wow'],
        ];

        return collect($all)
            ->filter(fn ($_, $type) => ($counts[$type] ?? 0) > 0)
            ->values()
            ->all();
    }

    public function reactionTotal(): int
    {
        $counts = $this->reactions;
        if ($this->reaction !== '') {
            $counts[$this->reaction] = ($counts[$this->reaction] ?? 0) + 1;
        }

        return (int) array_sum($counts);
    }

    public function render()
    {
        return view('livewire.newsfeed.post-card');
    }
}
