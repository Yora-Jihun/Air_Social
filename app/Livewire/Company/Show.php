<?php

namespace App\Livewire\Company;

use Livewire\Component;

class Show extends Component
{
    public string $activeTab = 'posts'; // posts | about | people | jobs | departments

    /** @var array<int, array<string, mixed>> */
    public array $departments = [];

    public ?int $selectedDept = null;

    public bool $createDeptOpen = false;

    public string $newDeptName = '';

    /** @var array<string, mixed> */
    public array $company = [];

    /** @var array<int, array<string, mixed>> */
    public array $posts = [];

    /** @var array<int, array<string, mixed>> */
    public array $admins = [];

    /** @var array<int, array<string, mixed>> */
    public array $people = [];

    /** @var array<int, array<string, mixed>> */
    public array $jobs = [];

    /** @var array<int, array<string, mixed>> */
    public array $related = [];

    public function mount(): void
    {
        // TODO: replace with Company::with(['posts','admins','jobs'])->where('slug', $slug)->firstOrFail()
        $this->company = [
            'name' => 'BDO Unibank',
            'tagline' => 'We find ways.',
            'logo' => null,
            'cover' => asset('images/bdo-banner.jpg'),
            'industry' => 'Banking',
            'location' => 'Makati City, Philippines',
            'website' => 'https://www.bdo.com.ph',
            'founded' => 1968,
            'size' => '10,001+ employees',
            'type' => 'Public Company',
            'followers' => 1280,
            'description' => "BDO Unibank is the largest bank in the Philippines by assets, loans, deposits, and trust funds under management. We provide a full range of commercial banking, investment banking, and wealth management services to retail, corporate, and institutional clients.",
            'is_member' => true,
            'is_admin' => true,
        ];

        $this->posts = [
            [
                'id' => 101,
                'author' => 'BDO Unibank',
                'role' => 'Official · BDO Unibank',
                'avatar' => null,
                'timestamp' => '3h',
                'visibility' => 'Public',
                'body' => 'We just launched the upgraded BDO Mobile Banking app with biometric login and instant fund transfers. Try it out and share your feedback so we can fine-tune the experience before the full rollout.',
                'like_count' => 214,
                'reactions' => ['like' => 120, 'heart' => 64, 'wow' => 30],
                'comment_count' => 42,
            ],
            [
                'id' => 102,
                'author' => 'BDO Unibank',
                'role' => 'Official · BDO Unibank',
                'avatar' => null,
                'timestamp' => '1d',
                'visibility' => 'Public',
                'body' => 'Now hiring Relationship Managers across our Metro Manila branches. If you love helping customers reach their financial goals, we would love to meet you.',
                'like_count' => 96,
                'reactions' => ['like' => 60, 'heart' => 28, 'wow' => 8],
                'comment_count' => 17,
            ],
        ];

        $this->admins = [
            ['name' => 'Maria Cristina Reyes', 'role' => 'Page Admin', 'avatar' => null],
            ['name' => 'Paolo Mendoza', 'role' => 'Content Editor', 'avatar' => null],
        ];

        $this->people = [
            ['name' => 'Maria Cristina Reyes', 'role' => 'Relationship Manager', 'avatar' => null],
            ['name' => 'Juan Miguel Santos', 'role' => 'Software Engineer', 'avatar' => null],
            ['name' => 'Ana Marie Cruz', 'role' => 'Branch Operations', 'avatar' => null],
            ['name' => 'Paolo Mendoza', 'role' => 'Data Analyst', 'avatar' => null],
        ];

        $this->jobs = [
            ['title' => 'Relationship Manager', 'location' => 'Makati', 'type' => 'Full-time'],
            ['title' => 'Software Engineer', 'location' => 'Taguig', 'type' => 'Full-time'],
            ['title' => 'Risk Analyst', 'location' => 'Mandaluyong', 'type' => 'Full-time'],
        ];

        $this->related = [
            ['name' => 'BPI', 'members' => 712, 'avatar' => null],
            ['name' => 'Metrobank', 'members' => 940, 'avatar' => null],
            ['name' => 'UnionBank', 'members' => 503, 'avatar' => null],
        ];

        // TODO: replace with $this->company->departments()->with('users')->get()
        $this->departments = [
            [
                'id' => 1,
                'name' => 'Retail Banking',
                'member_count' => 320,
                'lead' => 'Maria Cristina Reyes',
                'members' => [
                    ['name' => 'Maria Cristina Reyes', 'role' => 'Lead', 'avatar' => null],
                    ['name' => 'Ana Marie Cruz', 'role' => 'Member', 'avatar' => null],
                ],
            ],
            [
                'id' => 2,
                'name' => 'Technology',
                'member_count' => 145,
                'lead' => 'Juan Miguel Santos',
                'members' => [
                    ['name' => 'Juan Miguel Santos', 'role' => 'Lead', 'avatar' => null],
                    ['name' => 'Paolo Mendoza', 'role' => 'Member', 'avatar' => null],
                ],
            ],
            [
                'id' => 3,
                'name' => 'Operations',
                'member_count' => 210,
                'lead' => 'Paolo Mendoza',
                'members' => [
                    ['name' => 'Paolo Mendoza', 'role' => 'Lead', 'avatar' => null],
                    ['name' => 'Maria Cristina Reyes', 'role' => 'Member', 'avatar' => null],
                ],
            ],
        ];
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    // --- Department UI (static, no persistence yet) ---

    public function viewDepartment(int $id): void
    {
        $this->selectedDept = $id;
    }

    public function backToDepartments(): void
    {
        $this->selectedDept = null;
    }

    public function openCreateDept(): void
    {
        $this->createDeptOpen = true;
    }

    public function closeCreateDept(): void
    {
        $this->createDeptOpen = false;
        $this->newDeptName = '';
    }

    public function createDepartment(): void
    {
        // TODO: persist via Department::create([...]) + attach creator as company admin.
        $name = trim($this->newDeptName);
        if ($name === '') {
            return;
        }

        $nextId = collect($this->departments)->max('id') + 1;
        $this->departments[] = [
            'id' => $nextId,
            'name' => $name,
            'member_count' => 0,
            'lead' => null,
            'members' => [],
        ];

        $this->closeCreateDept();
    }

    public function setLead(int $deptId, string $userName): void
    {
        // TODO: persist via department_user pivot role update.
        foreach ($this->departments as &$dept) {
            if ($dept['id'] !== $deptId) {
                continue;
            }

            foreach ($dept['members'] as &$member) {
                $member['role'] = ($member['name'] === $userName) ? 'Lead' : 'Member';
            }
            unset($member);

            $dept['lead'] = $userName;
        }
        unset($dept);
    }

    public function render()
    {
        return view('livewire.company.show')->layout('layouts.newsfeed');
    }
}
