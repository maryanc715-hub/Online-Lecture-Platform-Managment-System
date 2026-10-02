@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('breadcrumbs')
    <span class="font-medium text-primary">Dashboard</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h1>
            <p class="text-slate-500 text-sm">Here's what's happening across the platform today.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 rounded-btn bg-white border border-slate-200 text-sm font-medium hover:bg-slate-50">Export Reports</a>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">+ Add User</a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label' => 'Students', 'value' => $stats['students'], 'icon' => 'users'],
            ['label' => 'Instructors', 'value' => $stats['instructors'], 'icon' => 'users'],
            ['label' => 'Courses', 'value' => $stats['courses'], 'icon' => 'book'],
            ['label' => 'Assignments', 'value' => $stats['assignments'], 'icon' => 'clipboard'],
            ['label' => 'Lecture Materials', 'value' => $stats['lectures'], 'icon' => 'document'],
            ['label' => 'Messages', 'value' => $stats['messages'], 'icon' => 'chat'],
            ['label' => 'Open Support Tickets', 'value' => $stats['tickets'], 'icon' => 'ticket'],
            ['label' => 'Pending Approvals', 'value' => $stats['pendingUsers'], 'icon' => 'user'],
        ] as $card)
        <div class="bg-white rounded-card p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-btn bg-secondary/10 flex items-center justify-center text-secondary">
                    @include('layouts.nav.icon', ['name' => $card['icon']])
                </div>
            </div>
            <p class="text-2xl font-bold text-primary">{{ $card['value'] }}</p>
            <p class="text-slate-500 text-sm">{{ $card['label'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-8">
        {{-- Enrollment Trend Chart --}}
        <div class="lg:col-span-2 bg-white rounded-card p-6 shadow-sm border border-slate-100">
            <h2 class="font-semibold text-primary mb-4">New Student Enrollments (6 months)</h2>
            <canvas id="enrollmentChart" height="110"></canvas>
        </div>

        {{-- Ticket Status Chart --}}
        <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100">
            <h2 class="font-semibold text-primary mb-4">Support Tickets by Status</h2>
            <canvas id="ticketChart" height="200"></canvas>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Recent Activity --}}
        <div class="lg:col-span-2 bg-white rounded-card p-6 shadow-sm border border-slate-100">
            <h2 class="font-semibold text-primary mb-4">Recent Activity</h2>
            <ul class="divide-y divide-slate-100">
                @forelse($recentActivities as $log)
                    <li class="py-3 flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-secondary mt-2"></div>
                        <div class="text-sm">
                            <p class="text-slate-700"><span class="font-medium">{{ $log->user->name ?? 'System' }}</span> {{ $log->description }}</p>
                            <p class="text-slate-400 text-xs">{{ $log->created_at->diffForHumans() }}</p>
                        </div>
                    </li>
                @empty
                    <li>
                        <x-empty-state title="No recent activity" message="Platform activity will appear here." icon="clock" />
                    </li>
                @endforelse
            </ul>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100">
            <h2 class="font-semibold text-primary mb-4">Quick Actions</h2>
            <div class="space-y-2 text-sm">
                <a href="{{ route('admin.courses.create') }}" class="block px-4 py-2.5 rounded-btn bg-primary/5 hover:bg-primary/10 text-primary font-medium">+ Create Course</a>
                <a href="{{ route('admin.announcements.create') }}" class="block px-4 py-2.5 rounded-btn bg-primary/5 hover:bg-primary/10 text-primary font-medium">+ Post Announcement</a>
                <a href="{{ route('admin.tickets.index') }}" class="block px-4 py-2.5 rounded-btn bg-primary/5 hover:bg-primary/10 text-primary font-medium">View Open Tickets</a>
                <a href="{{ route('admin.backup') }}" class="block px-4 py-2.5 rounded-btn bg-primary/5 hover:bg-primary/10 text-primary font-medium">Backup Database</a>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
new Chart(document.getElementById('enrollmentChart'), {
    type: 'line',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'New Students',
            data: @json($enrollmentTrend),
            borderColor: '#40916C',
            backgroundColor: 'rgba(64,145,108,0.15)',
            fill: true,
            tension: 0.35,
        }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});

new Chart(document.getElementById('ticketChart'), {
    type: 'doughnut',
    data: {
        labels: @json($ticketsByStatus->keys()),
        datasets: [{
            data: @json($ticketsByStatus->values()),
            backgroundColor: ['#1B4332', '#40916C', '#95D5B2', '#B7E4C7'],
        }]
    },
});
</script>
@endpush
