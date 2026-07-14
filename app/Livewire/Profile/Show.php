<?php

namespace App\Livewire\Profile;

use Livewire\Component;

class Show extends Component
{
    public string $activeTab = 'posts';

    /** @var array<string, mixed> */
    public array $profile = [];

    /** @var array<int, array<string, mixed>> */
    public array $posts = [];

    public bool $editOpen = false;

    public string $formHeadline = '';
    public string $formLocation = '';
    public string $formAbout = '';
    public string $formSkills = '';

    public function mount(): void
    {
        $this->profile = [
            'name' => auth()->user()->name ?? 'Juan Dela Cruz',
            'headline' => 'Relationship Manager · BDO Unibank',
            'location' => 'Makati City, Philippines',
            'about' => 'Relationship manager with 8+ years in retail banking. I help customers reach their financial goals through tailored advisory, and I care about clean processes and great team culture.',
            'joined' => 'Joined March 2024',
            'avatar' => null,
            'cover' => null,
            'experience' => [
                [
                    'title' => 'Relationship Manager',
                    'company' => 'BDO Unibank',
                    'period' => '2021 - Present',
                    'desc' => 'Manage a portfolio of retail clients; drive deposits, loans, and wealth products.',
                ],
                [
                    'title' => 'Teller',
                    'company' => 'BPI',
                    'period' => '2018 - 2021',
                    'desc' => 'Frontline banking, KYC, and customer service across branch operations.',
                ],
            ],
            'education' => [
                [
                    'school' => 'University of the Philippines',
                    'degree' => 'B.S. Business Administration',
                    'period' => '2014 - 2018',
                ],
            ],
            'skills' => ['Retail Banking', 'Customer Relations', 'KYC', 'Financial Advisory'],
        ];

        $this->posts = [
            [
                'id' => 301,
                'author' => $this->profile['name'],
                'role' => $this->profile['headline'],
                'avatar' => null,
                'timestamp' => '4h',
                'visibility' => 'Public',
                'body' => 'Sharing what I learned leading our branch digital onboarding rollout - small process tweaks saved new clients an average of 20 minutes.',
                'like_count' => 33,
                'reactions' => ['like' => 20, 'heart' => 9, 'wow' => 4],
                'comment_count' => 6,
            ],
            [
                'id' => 302,
                'author' => $this->profile['name'],
                'role' => $this->profile['headline'],
                'avatar' => null,
                'timestamp' => '2d',
                'visibility' => 'Public',
                'body' => 'Grateful to the BDO team for a strong quarter. On to the next one!',
                'like_count' => 57,
                'reactions' => ['like' => 30, 'heart' => 22, 'wow' => 5],
                'comment_count' => 11,
            ],
        ];
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function openEdit(): void
    {
        $this->formHeadline = $this->profile['headline'] ?? '';
        $this->formLocation = $this->profile['location'] ?? '';
        $this->formAbout = $this->profile['about'] ?? '';
        $this->formSkills = implode(', ', $this->profile['skills'] ?? []);
        $this->editOpen = true;
    }

    public function closeEdit(): void
    {
        $this->editOpen = false;
        $this->formHeadline = '';
        $this->formLocation = '';
        $this->formAbout = '';
        $this->formSkills = '';
    }

    public function saveProfile(): void
    {
        $this->profile['headline'] = trim($this->formHeadline);
        $this->profile['location'] = trim($this->formLocation);
        $this->profile['about'] = trim($this->formAbout);
        $this->profile['skills'] = collect(explode(',', $this->formSkills))
            ->map(fn ($s) => trim($s))
            ->filter()
            ->values()
            ->all();

        $this->closeEdit();
    }

    public function render()
    {
        return view('livewire.profile.show')->layout('layouts.newsfeed');
    }
}
