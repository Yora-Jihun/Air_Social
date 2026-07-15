<?php

namespace App\Livewire\Company;

use Livewire\Component;

class Show extends Component
{
    public string $activeTab = 'posts'; // posts | about | people | jobs | departments | <installed plugins>

    /** @var array<int, array<string, mixed>> */
    public array $departments = [];

    public ?int $selectedDept = null;

    public bool $createDeptOpen = false;

    public string $newDeptName = '';

    public string $newPost = '';

    public string $postScope = 'company'; // company | department

    public ?int $postDeptId = null;

    public bool $createPostOpen = false;

    public bool $pluginsOpen = false;

    /** @var array<int, string> */
    public array $installedPlugins = [];

    /** @var array<int, array<string, mixed>> */
    public array $attendanceRecords = [];

    /** @var array<string, mixed>|null */
    public ?array $selectedMember = null;

    public bool $revealPrivate = false;

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

        // TODO: replace with $this->company->departments()->with(['users','posts'])->get()
        // Each member carries static public + private (PII) info for the admin member-profile view.
        $this->departments = [
            [
                'id' => 1,
                'name' => 'Retail Banking',
                'member_count' => 320,
                'lead' => 'Maria Cristina Reyes',
                'members' => [
                    [
                        'name' => 'Maria Cristina Reyes', 'role' => 'Lead', 'avatar' => null,
                        'public' => [
                            ['label' => 'Email', 'value' => 'maria.reyes@bdo.com'],
                            ['label' => 'Phone', 'value' => '+63 917 555 0148'],
                            ['label' => 'Location', 'value' => 'Makati'],
                        ],
                        'private' => [
                            ['label' => 'SSS Number', 'type' => 'id', 'value' => '12-3456-7890'],
                            ['label' => 'Pag-IBIG Number', 'type' => 'id', 'value' => '1234-5678-9012'],
                            ['label' => 'PhilHealth Number', 'type' => 'id', 'value' => '12-345678901-2'],
                            ['label' => 'TIN', 'type' => 'id', 'value' => '123-456-789'],
                            ['label' => 'Employee ID', 'type' => 'id', 'value' => 'BDO-004821'],
                            ['label' => 'Company Assets', 'type' => 'assets', 'value' => 'MacBook Pro 14", iPhone 13, Building access card'],
                        ],
                    ],
                    [
                        'name' => 'Ana Marie Cruz', 'role' => 'Member', 'avatar' => null,
                        'public' => [
                            ['label' => 'Email', 'value' => 'ana.cruz@bdo.com'],
                            ['label' => 'Phone', 'value' => '+63 918 555 0177'],
                            ['label' => 'Location', 'value' => 'Makati'],
                        ],
                        'private' => [
                            ['label' => 'SSS Number', 'type' => 'id', 'value' => '23-4567-8901'],
                            ['label' => 'Pag-IBIG Number', 'type' => 'id', 'value' => '2345-6789-0123'],
                            ['label' => 'PhilHealth Number', 'type' => 'id', 'value' => '23-456789012-3'],
                            ['label' => 'TIN', 'type' => 'id', 'value' => '234-567-890'],
                            ['label' => 'Employee ID', 'type' => 'id', 'value' => 'BDO-005133'],
                            ['label' => 'Company Assets', 'type' => 'assets', 'value' => 'Dell Latitude, Building access card'],
                        ],
                    ],
                ],
                'posts' => [
                    [
                        'id' => 201,
                        'author' => 'Maria Cristina Reyes',
                        'role' => 'Department Admin · Retail Banking',
                        'avatar' => null,
                        'timestamp' => '2h',
                        'visibility' => 'Department',
                        'body' => 'Reminder: the new teller shift schedule starts next week. Please confirm your slots in the shared sheet so we can finalize the roster.',
                        'like_count' => 12,
                        'reactions' => ['like' => 8, 'heart' => 3, 'wow' => 1],
                        'comment_count' => 3,
                    ],
                    [
                        'id' => 202,
                        'author' => 'Ana Marie Cruz',
                        'role' => 'Member · Retail Banking',
                        'avatar' => null,
                        'timestamp' => '5h',
                        'visibility' => 'Department',
                        'body' => 'Counter 3 is back online after maintenance. Thanks for the patience everyone!',
                        'like_count' => 5,
                        'reactions' => ['like' => 4, 'heart' => 1, 'wow' => 0],
                        'comment_count' => 1,
                    ],
                ],
            ],
            [
                'id' => 2,
                'name' => 'Technology',
                'member_count' => 145,
                'lead' => 'Juan Miguel Santos',
                'members' => [
                    [
                        'name' => 'Juan Miguel Santos', 'role' => 'Lead', 'avatar' => null,
                        'public' => [
                            ['label' => 'Email', 'value' => 'juan.santos@bdo.com'],
                            ['label' => 'Phone', 'value' => '+63 919 555 0188'],
                            ['label' => 'Location', 'value' => 'Taguig'],
                        ],
                        'private' => [
                            ['label' => 'SSS Number', 'type' => 'id', 'value' => '34-5678-9012'],
                            ['label' => 'Pag-IBIG Number', 'type' => 'id', 'value' => '3456-7890-1234'],
                            ['label' => 'PhilHealth Number', 'type' => 'id', 'value' => '34-567890123-4'],
                            ['label' => 'TIN', 'type' => 'id', 'value' => '345-678-901'],
                            ['label' => 'Employee ID', 'type' => 'id', 'value' => 'BDO-006042'],
                            ['label' => 'Company Assets', 'type' => 'assets', 'value' => 'MacBook Pro 16", iPhone 14, Dev server access'],
                        ],
                    ],
                    [
                        'name' => 'Paolo Mendoza', 'role' => 'Member', 'avatar' => null,
                        'public' => [
                            ['label' => 'Email', 'value' => 'paolo.mendoza@bdo.com'],
                            ['label' => 'Phone', 'value' => '+63 920 555 0199'],
                            ['label' => 'Location', 'value' => 'Taguig'],
                        ],
                        'private' => [
                            ['label' => 'SSS Number', 'type' => 'id', 'value' => '45-6789-0123'],
                            ['label' => 'Pag-IBIG Number', 'type' => 'id', 'value' => '4567-8901-2345'],
                            ['label' => 'PhilHealth Number', 'type' => 'id', 'value' => '45-678901234-5'],
                            ['label' => 'TIN', 'type' => 'id', 'value' => '456-789-012'],
                            ['label' => 'Employee ID', 'type' => 'id', 'value' => 'BDO-007115'],
                            ['label' => 'Company Assets', 'type' => 'assets', 'value' => 'Lenovo ThinkPad, Building access card'],
                        ],
                    ],
                ],
                'posts' => [
                    [
                        'id' => 203,
                        'author' => 'Juan Miguel Santos',
                        'role' => 'Department Admin · Technology',
                        'avatar' => null,
                        'timestamp' => '1h',
                        'visibility' => 'Department',
                        'body' => 'Deploy freeze lifted. You may merge the v2 API branch to staging and run the smoke tests.',
                        'like_count' => 8,
                        'reactions' => ['like' => 6, 'heart' => 1, 'wow' => 1],
                        'comment_count' => 2,
                    ],
                ],
            ],
            [
                'id' => 3,
                'name' => 'Operations',
                'member_count' => 210,
                'lead' => 'Paolo Mendoza',
                'members' => [
                    [
                        'name' => 'Paolo Mendoza', 'role' => 'Lead', 'avatar' => null,
                        'public' => [
                            ['label' => 'Email', 'value' => 'paolo.mendoza@bdo.com'],
                            ['label' => 'Phone', 'value' => '+63 920 555 0199'],
                            ['label' => 'Location', 'value' => 'Mandaluyong'],
                        ],
                        'private' => [
                            ['label' => 'SSS Number', 'type' => 'id', 'value' => '45-6789-0123'],
                            ['label' => 'Pag-IBIG Number', 'type' => 'id', 'value' => '4567-8901-2345'],
                            ['label' => 'PhilHealth Number', 'type' => 'id', 'value' => '45-678901234-5'],
                            ['label' => 'TIN', 'type' => 'id', 'value' => '456-789-012'],
                            ['label' => 'Employee ID', 'type' => 'id', 'value' => 'BDO-007115'],
                            ['label' => 'Company Assets', 'type' => 'assets', 'value' => 'Lenovo ThinkPad, Building access card'],
                        ],
                    ],
                    [
                        'name' => 'Maria Cristina Reyes', 'role' => 'Member', 'avatar' => null,
                        'public' => [
                            ['label' => 'Email', 'value' => 'maria.reyes@bdo.com'],
                            ['label' => 'Phone', 'value' => '+63 917 555 0148'],
                            ['label' => 'Location', 'value' => 'Makati'],
                        ],
                        'private' => [
                            ['label' => 'SSS Number', 'type' => 'id', 'value' => '12-3456-7890'],
                            ['label' => 'Pag-IBIG Number', 'type' => 'id', 'value' => '1234-5678-9012'],
                            ['label' => 'PhilHealth Number', 'type' => 'id', 'value' => '12-345678901-2'],
                            ['label' => 'TIN', 'type' => 'id', 'value' => '123-456-789'],
                            ['label' => 'Employee ID', 'type' => 'id', 'value' => 'BDO-004821'],
                            ['label' => 'Company Assets', 'type' => 'assets', 'value' => 'MacBook Pro 14", iPhone 13, Building access card'],
                        ],
                    ],
                ],
                'posts' => [
                    [
                        'id' => 204,
                        'author' => 'Paolo Mendoza',
                        'role' => 'Department Admin · Operations',
                        'avatar' => null,
                        'timestamp' => '3h',
                        'visibility' => 'Department',
                        'body' => 'Monthly reconciliation is done - figures balanced. Great job team.',
                        'like_count' => 9,
                        'reactions' => ['like' => 5, 'heart' => 3, 'wow' => 1],
                        'comment_count' => 4,
                    ],
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

    // --- Member profile (admin view, static) ---

    public function viewMember(int $deptId, string $memberName): void
    {
        // TODO: authorize via DepartmentPolicy/CompanyPolicy (company or department admin only).
        foreach ($this->departments as $dept) {
            if ($dept['id'] !== $deptId) {
                continue;
            }
            foreach ($dept['members'] as $member) {
                if (($member['name'] ?? null) === $memberName) {
                    $this->selectedMember = $member + ['department' => $dept['name']];
                    $this->revealPrivate = false;
                    return;
                }
            }
        }
    }

    public function closeMember(): void
    {
        $this->selectedMember = null;
        $this->revealPrivate = false;
    }

    public function toggleReveal(): void
    {
        $this->revealPrivate = ! $this->revealPrivate;
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

    // --- Create post modal (composer style) ---

    public function openCreatePost(string $scope = 'company', ?int $deptId = null): void
    {
        $this->postScope = $scope;
        $this->postDeptId = $deptId;
        $this->newPost = '';
        $this->createPostOpen = true;
    }

    public function closeCreatePost(): void
    {
        $this->createPostOpen = false;
        $this->newPost = '';
        $this->postScope = 'company';
        $this->postDeptId = null;
    }

    public function openPlugins(): void
    {
        $this->pluginsOpen = true;
    }

    public function closePlugins(): void
    {
        $this->pluginsOpen = false;
    }

    public function importPlugin(string $key): void
    {
        if (! array_key_exists($key, $this->pluginManifest())) {
            return;
        }

        if (! in_array($key, $this->installedPlugins, true)) {
            $this->installedPlugins[] = $key;
        }

        if ($key === 'attendance') {
            $this->seedAttendance();
        }

        $this->pluginsOpen = false;
        $this->activeTab = $key;
    }

    /** Available plugins the admin can import as tabs. */
    public function pluginManifest(): array
    {
        return [
            'attendance' => ['name' => 'Attendance', 'icon' => 'calendar', 'desc' => 'Log attendance and work hours.'],
            'payroll' => ['name' => 'Payroll', 'icon' => 'briefcase', 'desc' => 'Run payroll and track compensation.'],
            'tasks' => ['name' => 'Tasks', 'icon' => 'check', 'desc' => 'Assign and track team tasks.'],
            'announcements' => ['name' => 'Announcements', 'icon' => 'bell', 'desc' => 'Broadcast company-wide notices.'],
        ];
    }

    protected function seedAttendance(): void
    {
        $this->attendanceRecords = [
            [
                'name' => 'Maria Cristina Reyes', 'avatar' => null,
                'date' => '2026-07-15', 'time' => '08:02 AM',
                'location' => 'BDO Makati Branch', 'coordinate' => '14.5547, 121.0244',
                'weather' => 'Partly cloudy', 'altitude' => '23 m',
            ],
            [
                'name' => 'Juan Miguel Santos', 'avatar' => null,
                'date' => '2026-07-15', 'time' => '08:11 AM',
                'location' => 'BDO Taguig Hub', 'coordinate' => '14.5176, 121.0509',
                'weather' => 'Sunny', 'altitude' => '41 m',
            ],
            [
                'name' => 'Ana Marie Cruz', 'avatar' => null,
                'date' => '2026-07-15', 'time' => '08:25 AM',
                'location' => 'BDO Quezon Ave.', 'coordinate' => '14.6312, 121.0123',
                'weather' => 'Light rain', 'altitude' => '58 m',
            ],
            [
                'name' => 'Paolo Mendoza', 'avatar' => null,
                'date' => '2026-07-14', 'time' => '05:48 PM',
                'location' => 'BDO Ortigas Center', 'coordinate' => '14.5867, 121.0614',
                'weather' => 'Clear', 'altitude' => '35 m',
            ],
            [
                'name' => 'Carla Delos Reyes', 'avatar' => null,
                'date' => '2026-07-14', 'time' => '06:02 PM',
                'location' => 'BDO Alabang', 'coordinate' => '14.4267, 121.0250',
                'weather' => 'Cloudy', 'altitude' => '12 m',
            ],
        ];
    }

    public function createPost(): void
    {
        // TODO: persist as a company- or department-scoped post.
        $body = trim($this->newPost);
        if ($body === '') {
            return;
        }

        if ($this->postScope === 'department' && $this->postDeptId !== null) {
            foreach ($this->departments as &$dept) {
                if ((int) $dept['id'] === (int) $this->postDeptId) {
                    $nextId = collect($dept['posts'] ?? [])->max('id') + 1;
                    $post = [
                        'id' => $nextId,
                        'author' => auth()->user()->name,
                        'role' => 'Department Admin · ' . $dept['name'],
                        'avatar' => null,
                        'timestamp' => 'now',
                        'visibility' => 'Department',
                        'body' => $body,
                        'like_count' => 0,
                        'reactions' => ['like' => 0, 'heart' => 0, 'wow' => 0],
                        'comment_count' => 0,
                    ];
                    // Prepend so the newest post shows at the top.
                    $dept['posts'] = array_merge([$post], $dept['posts'] ?? []);
                    break;
                }
            }
            unset($dept);
        } else {
            $nextId = collect($this->posts)->max('id') + 1;
            $post = [
                'id' => $nextId,
                'author' => $this->company['name'],
                'role' => 'Official · ' . $this->company['name'],
                'avatar' => null,
                'timestamp' => 'now',
                'visibility' => 'Public',
                'body' => $body,
                'like_count' => 0,
                'reactions' => ['like' => 0, 'heart' => 0, 'wow' => 0],
                'comment_count' => 0,
            ];
            // Prepend so the newest post shows at the top.
            array_unshift($this->posts, $post);
        }

        $this->closeCreatePost();
    }

    public function render()
    {
        return view('livewire.company.show')->layout('layouts.newsfeed');
    }
}
