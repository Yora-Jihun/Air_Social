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

    public ?string $fullscreenPlugin = null;

    /** @var array<int, array<string, mixed>> */
    public array $attendanceRecords = [];

    public ?string $attendanceHistoryEmployee = null;

    public string $attendanceHistoryRange = '7'; // 7 | 15 | 30 | 365

    /** @var array<int, array<string, mixed>> */
    public array $payrollRecords = [];

    public ?int $payslipIndex = null;

    public bool $showGeneratedPayslip = false;

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

    public function expandPlugin(string $key): void
    {
        if (! in_array($key, $this->installedPlugins, true)) {
            return;
        }

        $this->fullscreenPlugin = $key;
    }

    public function collapsePlugin(): void
    {
        $this->fullscreenPlugin = null;
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

        if ($key === 'payroll') {
            $this->seedPayroll();
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

    // --- Attendance history modal (static, view-only) ---

    public function viewAttendanceHistory(string $name): void
    {
        $this->attendanceHistoryEmployee = $name;
        $this->attendanceHistoryRange = '7';
    }

    public function setAttendanceHistoryRange(string $range): void
    {
        if (! array_key_exists($range, $this->attendanceHistoryRangeOptions())) {
            return;
        }

        $this->attendanceHistoryRange = $range;
    }

    public function closeAttendanceHistory(): void
    {
        $this->attendanceHistoryEmployee = null;
    }

    /** Range key => label shown on the tabs. */
    public function attendanceHistoryRangeOptions(): array
    {
        return [
            '7' => 'Last 7 days',
            '15' => 'Last 15 days',
            '30' => 'Last month',
            '365' => 'All time',
        ];
    }

    /** Status key => label/color meta shared by the summary tiles, donut and day-strip. */
    public function attendanceStatusMeta(): array
    {
        return [
            'present' => ['label' => 'Present', 'dot' => 'bg-emerald-500', 'text' => 'text-emerald-700', 'chip' => 'bg-emerald-50 text-emerald-700', 'hex' => '#10b981'],
            'absent' => ['label' => 'Absent', 'dot' => 'bg-rose-500', 'text' => 'text-rose-700', 'chip' => 'bg-rose-50 text-rose-700', 'hex' => '#f43f5e'],
            'sick' => ['label' => 'Sick leave', 'dot' => 'bg-amber-500', 'text' => 'text-amber-700', 'chip' => 'bg-amber-50 text-amber-700', 'hex' => '#f59e0b'],
            'vacation' => ['label' => 'Vacation leave', 'dot' => 'bg-violet-500', 'text' => 'text-violet-700', 'chip' => 'bg-violet-50 text-violet-700', 'hex' => '#8b5cf6'],
        ];
    }

    /** Badge colors for the "late" flag — separate from status since a day is Present *and* late, not either/or. */
    public function attendanceLateMeta(): array
    {
        return ['dot' => 'bg-orange-500', 'text' => 'text-orange-700', 'chip' => 'bg-orange-50 text-orange-700'];
    }

    /** Badge colors for PH holidays — shown in both the Attendance history modal and Payroll. */
    public function attendanceHolidayMeta(): array
    {
        return [
            'regular' => ['label' => 'Regular holiday', 'dot' => 'bg-yellow-500', 'text' => 'text-yellow-700', 'chip' => 'bg-yellow-50 text-yellow-700'],
            'special' => ['label' => 'Special holiday', 'dot' => 'bg-cyan-500', 'text' => 'text-cyan-700', 'chip' => 'bg-cyan-50 text-cyan-700'],
        ];
    }

    /**
     * Approximate PH public holiday calendar (regular vs. special non-working) covering the window the
     * attendance/payroll demo data spans. Regular holidays pay double when worked, and still pay 100% when
     * unworked (unless absent). Special non-working holidays pay 130% when worked, otherwise no work no pay.
     */
    protected const PH_HOLIDAYS = [
        '2025-08-21' => ['name' => 'Ninoy Aquino Day', 'type' => 'special'],
        '2025-08-25' => ['name' => 'National Heroes Day', 'type' => 'regular'],
        '2025-11-01' => ['name' => "All Saints' Day", 'type' => 'special'],
        '2025-11-30' => ['name' => 'Bonifacio Day', 'type' => 'regular'],
        '2025-12-08' => ['name' => 'Immaculate Conception', 'type' => 'special'],
        '2025-12-24' => ['name' => 'Christmas Eve', 'type' => 'special'],
        '2025-12-25' => ['name' => 'Christmas Day', 'type' => 'regular'],
        '2025-12-30' => ['name' => 'Rizal Day', 'type' => 'regular'],
        '2025-12-31' => ['name' => 'Last Day of the Year', 'type' => 'special'],
        '2026-01-01' => ['name' => "New Year's Day", 'type' => 'regular'],
        '2026-02-17' => ['name' => 'Chinese New Year', 'type' => 'special'],
        '2026-02-25' => ['name' => 'EDSA People Power Anniversary', 'type' => 'special'],
        '2026-04-02' => ['name' => 'Maundy Thursday', 'type' => 'regular'],
        '2026-04-03' => ['name' => 'Good Friday', 'type' => 'regular'],
        '2026-04-04' => ['name' => 'Black Saturday', 'type' => 'special'],
        '2026-04-09' => ['name' => 'Araw ng Kagitingan', 'type' => 'regular'],
        '2026-05-01' => ['name' => 'Labor Day', 'type' => 'regular'],
        '2026-06-12' => ['name' => 'Independence Day', 'type' => 'regular'],
    ];

    /** Minutes short of a full 10-hour shift, formatted like "1h 30m late" / "45m late". */
    public function formatLateDuration(int $minutes): string
    {
        $hours = intdiv($minutes, 60);
        $mins = $minutes % 60;

        if ($hours > 0 && $mins > 0) {
            return "{$hours}h {$mins}m late";
        }

        if ($hours > 0) {
            return "{$hours}h late";
        }

        return "{$mins}m late";
    }

    /** @return array<int, array<string, mixed>> Deterministic per-employee daily attendance, oldest to newest. */
    public function attendanceHistoryDays(): array
    {
        if (! $this->attendanceHistoryEmployee) {
            return [];
        }

        return $this->buildAttendanceHistory($this->attendanceHistoryEmployee, (int) $this->attendanceHistoryRange);
    }

    /** A full shift is 8 logged hours; anything less is flagged "late" by the shortfall. */
    protected const FULL_SHIFT_HOURS = 8.0;

    protected function buildAttendanceHistory(string $name, int $days): array
    {
        $today = \Carbon\Carbon::parse('2026-07-18');
        $history = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $history[] = $this->attendanceDayRecord($name, $today->copy()->subDays($i));
        }

        return $history;
    }

    /**
     * Deterministic single-day attendance roll for one employee — the shared source of truth for both the
     * Attendance history modal and the Payroll calculator, so a given employee+date always resolves the same way.
     */
    protected function attendanceDayRecord(string $name, \Carbon\Carbon $date): array
    {
        $dateKey = $date->format('Y-m-d');
        $holiday = self::PH_HOLIDAYS[$dateKey] ?? null;

        $base = [
            'date' => $dateKey, 'day' => $date->format('D'),
            'holiday_name' => $holiday['name'] ?? null,
            'holiday_type' => $holiday['type'] ?? null,
        ];

        if ($date->isWeekend()) {
            return $base + [
                'status' => 'weekend', 'time_in' => null, 'time_out' => null, 'hours' => 0,
                'location' => null, 'weather' => null, 'altitude' => null, 'late_minutes' => null,
            ];
        }

        // Weights sum to 100; seeded on name+date so the same day always rolls the same way.
        $weights = ['present' => 82, 'absent' => 6, 'sick' => 6, 'vacation' => 6];
        $locations = ['BDO Makati Branch', 'BDO Taguig Hub', 'BDO Quezon Ave.', 'BDO Ortigas Center', 'BDO Alabang'];
        $weathers = ['Sunny', 'Partly cloudy', 'Cloudy', 'Light rain', 'Clear'];

        mt_srand(crc32($name.$dateKey));
        $roll = mt_rand(1, 100);

        $status = 'present';
        $cumulative = 0;
        foreach ($weights as $key => $weight) {
            $cumulative += $weight;
            if ($roll <= $cumulative) {
                $status = $key;
                break;
            }
        }

        $onSite = $status === 'present';
        // Wide enough spread either side of the 8h threshold that "present" and "late" don't always coincide.
        $hours = $onSite ? round(mt_rand(65, 98) / 10, 1) : 0;

        return $base + [
            'status' => $status,
            'time_in' => $onSite ? sprintf('%02d:%02d AM', mt_rand(7, 8), mt_rand(0, 59)) : null,
            'time_out' => $onSite ? sprintf('%02d:%02d PM', mt_rand(5, 6), mt_rand(0, 59)) : null,
            'hours' => $hours,
            'location' => $onSite ? $locations[mt_rand(0, count($locations) - 1)] : null,
            'weather' => $onSite ? $weathers[mt_rand(0, count($weathers) - 1)] : null,
            'altitude' => $onSite ? mt_rand(10, 60).' m' : null,
            'late_minutes' => $onSite && $hours < self::FULL_SHIFT_HOURS
                ? (int) round((self::FULL_SHIFT_HOURS - $hours) * 60)
                : null,
        ];
    }

    // Semi-monthly pay period the payroll demo runs — Jun 1-15, 2026 was picked because it contains a real
    // PH regular holiday (Independence Day, Jun 12), so the double-pay rule actually has something to show.
    protected const PAYROLL_PERIOD_START = '2026-06-01';

    protected const PAYROLL_PERIOD_END = '2026-06-15';

    protected const PAYROLL_PAY_DATE = '2026-06-16';

    // Approximate 2026 NCR-area daily rates for a security agency's rank-and-file/supervisory roles.
    protected const POSITION_DAILY_RATE = [
        'Security Guard' => 650.0,
        'Security Officer' => 750.0,
        'Operation In Charge' => 950.0,
        'Area Operation Manager' => 1500.0,
    ];

    public function payrollPeriodLabel(): string
    {
        return 'Jun 1 - Jun 15, 2026';
    }

    protected function seedPayroll(): void
    {
        $employees = [
            ['name' => 'Maria Cristina Reyes', 'avatar' => null, 'employee_id' => 'BDO-004821', 'position' => 'Security Guard'],
            ['name' => 'Juan Miguel Santos', 'avatar' => null, 'employee_id' => 'BDO-006042', 'position' => 'Operation In Charge'],
            ['name' => 'Ana Marie Cruz', 'avatar' => null, 'employee_id' => 'BDO-005133', 'position' => 'Area Operation Manager'],
            ['name' => 'Paolo Mendoza', 'avatar' => null, 'employee_id' => 'BDO-007115', 'position' => 'Security Officer'],
            ['name' => 'Carla Delos Reyes', 'avatar' => null, 'employee_id' => 'BDO-008270', 'position' => 'Security Guard'],
        ];

        $this->payrollRecords = array_map(fn (array $employee) => $this->computePayroll($employee), $employees);
    }

    /**
     * Runs one employee's attendance for the pay period through PH payroll rules: no-work-no-pay for absences
     * and leave, a per-minute deduction for lateness, 1.25x OT beyond 8h, and PH holiday-pay multipliers
     * (200% worked / 100% unworked-but-not-absent on regular holidays, 130% worked on special holidays).
     */
    protected function computePayroll(array $employee): array
    {
        $dailyRate = self::POSITION_DAILY_RATE[$employee['position']] ?? 650.0;
        $hourlyRate = $dailyRate / 8;
        $minuteRate = $hourlyRate / 60;

        $basicPay = 0.0;
        $holidayPay = 0.0;
        $overtimePay = 0.0;
        $lateDeduction = 0.0;
        $daysPresent = 0;
        $daysAbsent = 0;
        $daysLeave = 0;
        $daysLate = 0;
        $holidaysWorked = [];

        $start = \Carbon\Carbon::parse(self::PAYROLL_PERIOD_START);
        $end = \Carbon\Carbon::parse(self::PAYROLL_PERIOD_END);

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if ($date->isWeekend()) {
                continue;
            }

            $day = $this->attendanceDayRecord($employee['name'], $date);
            $isRegularHoliday = $day['holiday_type'] === 'regular';
            $isSpecialHoliday = $day['holiday_type'] === 'special';

            if ($day['status'] === 'present') {
                $daysPresent++;
                $basicPay += $dailyRate;

                if ($day['hours'] > 8) {
                    $overtimePay += ($day['hours'] - 8) * $hourlyRate * 1.25;
                }

                if ($day['late_minutes']) {
                    $lateDeduction += $day['late_minutes'] * $minuteRate;
                    $daysLate++;
                }

                if ($isRegularHoliday) {
                    $holidayPay += $dailyRate; // worked regular holiday: base + this premium = 200%
                    $holidaysWorked[] = $day['holiday_name'];
                } elseif ($isSpecialHoliday) {
                    $holidayPay += $dailyRate * 0.3; // worked special holiday: base + this premium = 130%
                    $holidaysWorked[] = $day['holiday_name'];
                }
            } elseif ($day['status'] === 'absent') {
                $daysAbsent++; // no work, no pay — forfeits any holiday pay too
            } else {
                $daysLeave++; // sick/vacation leave: unpaid, except a regular holiday still pays statutory 100%

                if ($isRegularHoliday) {
                    $holidayPay += $dailyRate;
                }
            }
        }

        $grossPay = $basicPay + $holidayPay + $overtimePay - $lateDeduction;
        $sss = $this->calculateSss($grossPay);
        $philhealth = $this->calculatePhilhealth($grossPay);
        $pagibig = $this->calculatePagibig($grossPay);
        $tax = $this->calculateWithholdingTax(max(0, $grossPay - $sss - $philhealth - $pagibig));

        return $employee + [
            'daily_rate' => $dailyRate,
            'base_pay' => round($basicPay, 2),
            'holiday_pay' => round($holidayPay, 2),
            'overtime' => round($overtimePay, 2),
            'late_deduction' => round($lateDeduction, 2),
            'gross_pay' => round($grossPay, 2),
            'days_present' => $daysPresent,
            'days_absent' => $daysAbsent,
            'days_leave' => $daysLeave,
            'days_late' => $daysLate,
            'holidays_worked' => array_values(array_unique(array_filter($holidaysWorked))),
            'deductions' => ['sss' => $sss, 'philhealth' => $philhealth, 'pagibig' => $pagibig, 'tax' => $tax],
            'net_pay' => round($grossPay - $sss - $philhealth - $pagibig - $tax, 2),
            'status' => 'pending',
            'pay_date' => self::PAYROLL_PAY_DATE,
        ];
    }

    /** 2025 SSS table, simplified to its 4.5% employee-share formula over a ₱500-bracketed, ₱5,000-35,000 salary credit. */
    protected function calculateSss(float $grossPay): float
    {
        $msc = max(5000, min(35000, floor($grossPay / 500) * 500));

        return round($msc * 0.045, 2);
    }

    /** 2025 PhilHealth: 5% of monthly basic salary split employer/employee (2.5% each), ₱10,000-100,000 income band. */
    protected function calculatePhilhealth(float $grossPay): float
    {
        $base = max(10000, min(100000, $grossPay));

        return round($base * 0.025, 2);
    }

    /** Pag-IBIG: employee share is 2% of monthly compensation, capped at a ₱10,000 contribution base (max ₱200). */
    protected function calculatePagibig(float $grossPay): float
    {
        return round(min($grossPay, 10000) * 0.02, 2);
    }

    /** BIR TRAIN-law semi-monthly withholding tax table (effective 2023 onward). */
    protected function calculateWithholdingTax(float $taxable): float
    {
        $tax = match (true) {
            $taxable <= 10416 => 0.0,
            $taxable <= 16666 => ($taxable - 10417) * 0.15,
            $taxable <= 33332 => 937.50 + ($taxable - 16667) * 0.20,
            $taxable <= 83332 => 4270.70 + ($taxable - 33333) * 0.25,
            $taxable <= 333332 => 16770.70 + ($taxable - 83333) * 0.30,
            $taxable <= 583332 => 91770.70 + ($taxable - 333333) * 0.32,
            default => 200770.70 + ($taxable - 583333) * 0.35,
        };

        return round(max(0, $tax), 2);
    }

    public function runPayroll(): void
    {
        foreach ($this->payrollRecords as &$rec) {
            $rec['status'] = 'paid';
        }
        unset($rec);
    }

    // --- Payroll breakdown / payslip modal (static, view-only) ---

    public function viewPayslip(int $index): void
    {
        if (! isset($this->payrollRecords[$index])) {
            return;
        }

        $this->payslipIndex = $index;
        $this->showGeneratedPayslip = false;
    }

    public function closePayslip(): void
    {
        $this->payslipIndex = null;
        $this->showGeneratedPayslip = false;
    }

    public function generatePayslip(): void
    {
        // TODO: replace with a real payslip render/PDF export once payroll has a backend.
        $this->showGeneratedPayslip = true;
    }

    public function backToPayslipBreakdown(): void
    {
        $this->showGeneratedPayslip = false;
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
