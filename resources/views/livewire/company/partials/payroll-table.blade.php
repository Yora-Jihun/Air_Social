@php
    $totalNet = collect($payrollRecords)->sum('net_pay');
    $paidCount = collect($payrollRecords)->where('status', 'paid')->count();
    $pendingCount = collect($payrollRecords)->where('status', 'pending')->count();
@endphp
<div>
    {{-- Summary --}}
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <div class="rounded-xl border border-gray-200 p-3">
            <p class="text-xs text-gray-500">Total net pay</p>
            <p class="mt-1 text-lg font-bold text-gray-900">₱{{ number_format($totalNet, 2) }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 p-3">
            <p class="text-xs text-gray-500">Employees</p>
            <p class="mt-1 text-lg font-bold text-gray-900">{{ count($payrollRecords) }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 p-3">
            <p class="text-xs text-gray-500">Paid</p>
            <p class="mt-1 text-lg font-bold text-emerald-600">{{ $paidCount }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 p-3">
            <p class="text-xs text-gray-500">Pending</p>
            <p class="mt-1 text-lg font-bold text-amber-600">{{ $pendingCount }}</p>
        </div>
    </div>

    <div class="mt-4 flex items-center justify-between">
        <p class="text-xs text-gray-500">
            Pay period: <span class="font-medium text-gray-700">{{ $this->payrollPeriodLabel() }}</span>
            <span class="text-gray-400">· computed from attendance, PH-rules</span>
        </p>
        @if ($pendingCount > 0)
            <button wire:click="runPayroll" type="button"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-blue-700">
                <x-icon name="briefcase" class="h-4 w-4" />
                Run payroll
            </button>
        @endif
    </div>

    {{-- Table --}}
    <div class="mt-3 overflow-auto rounded-xl border border-gray-200">
        <table class="w-full border-collapse text-left text-sm">
            <thead class="sticky top-0 bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-2.5">Employee</th>
                    <th class="px-4 py-2.5">Position</th>
                    <th class="px-4 py-2.5">Attendance</th>
                    <th class="px-4 py-2.5">Base pay</th>
                    <th class="px-4 py-2.5">Holiday pay</th>
                    <th class="px-4 py-2.5">Overtime</th>
                    <th class="px-4 py-2.5">Late</th>
                    <th class="px-4 py-2.5">Deductions</th>
                    <th class="px-4 py-2.5">Net pay</th>
                    <th class="px-4 py-2.5">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($payrollRecords as $rec)
                    @php
                        $deductionsTotal = array_sum($rec['deductions'] ?? []);
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2.5">
                            <button wire:click="viewPayslip({{ $loop->index }})" type="button"
                                    class="flex items-center gap-3 rounded-lg text-left transition hover:text-blue-600">
                                <x-avatar :src="$rec['avatar'] ?? null" :name="$rec['name']" size="sm" />
                                <span class="text-sm font-medium text-gray-800 hover:text-blue-600">{{ $rec['name'] }}</span>
                            </button>
                        </td>
                        <td class="whitespace-nowrap px-4 py-2.5 text-gray-600">{{ $rec['position'] }}</td>
                        <td class="whitespace-nowrap px-4 py-2.5 text-[11px]">
                            <span class="font-semibold text-emerald-600">{{ $rec['days_present'] }}P</span>
                            @if ($rec['days_absent'] > 0)
                                <span class="text-rose-600">· {{ $rec['days_absent'] }}A</span>
                            @endif
                            @if ($rec['days_leave'] > 0)
                                <span class="text-violet-600">· {{ $rec['days_leave'] }}L</span>
                            @endif
                            @if ($rec['days_late'] > 0)
                                <span class="text-orange-600">· {{ $rec['days_late'] }} late</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-4 py-2.5 text-gray-800">₱{{ number_format($rec['base_pay'], 2) }}</td>
                        <td class="whitespace-nowrap px-4 py-2.5 {{ $rec['holiday_pay'] > 0 ? 'font-medium text-yellow-700' : 'text-gray-400' }}">
                            {{ $rec['holiday_pay'] > 0 ? '₱'.number_format($rec['holiday_pay'], 2) : '—' }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-2.5 text-gray-600">₱{{ number_format($rec['overtime'], 2) }}</td>
                        <td class="whitespace-nowrap px-4 py-2.5 {{ $rec['late_deduction'] > 0 ? 'text-orange-600' : 'text-gray-400' }}">
                            {{ $rec['late_deduction'] > 0 ? '-₱'.number_format($rec['late_deduction'], 2) : '—' }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-2.5 text-rose-600">-₱{{ number_format($deductionsTotal, 2) }}</td>
                        <td class="whitespace-nowrap px-4 py-2.5 font-semibold text-gray-900">₱{{ number_format($rec['net_pay'], 2) }}</td>
                        <td class="whitespace-nowrap px-4 py-2.5">
                            @if ($rec['status'] === 'paid')
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700">
                                    Paid
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-semibold text-amber-700">
                                    Pending
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
