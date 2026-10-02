@extends('layouts.app')

@section('title', 'Announcements')
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Announcements</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Announcements</h1>
            <p class="text-slate-500 text-sm">Manage platform-wide announcements.</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">+ New Announcement</a>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <select name="audience" class="rounded-btn border-slate-200 bg-white text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    <option value="">All Audiences</option>
                    @foreach(['all', 'students', 'instructors', 'support_staff'] as $audience)
                        <option value="{{ $audience }}" {{ request('audience') === $audience ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $audience)) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Title</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Audience</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Status</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Author</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Date</th>
                        <th class="text-right px-6 py-3 font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($announcements as $announcement)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $announcement->title }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary/10 text-secondary capitalize">
                                    {{ str_replace('_', ' ', $announcement->audience) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($announcement->is_published)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Published</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $announcement->creator->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-slate-400">{{ $announcement->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.announcements.show', $announcement) }}" class="px-3 py-1.5 rounded-btn bg-secondary/10 text-secondary text-xs font-medium hover:bg-secondary/20 transition">View</a>
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="px-3 py-1.5 rounded-btn bg-primary/5 text-primary text-xs font-medium hover:bg-primary/10 transition">Edit</a>
                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Delete this announcement?')">
                                        @csrf @method('DELETE')
                                        <button class="px-3 py-1.5 rounded-btn bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <x-empty-state title="No announcements found" message="Post an announcement to share updates with the community." icon="megaphone" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $announcements->links() }}
    </div>
@endsection