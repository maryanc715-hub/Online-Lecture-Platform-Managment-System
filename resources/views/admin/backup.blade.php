@extends('layouts.app')

@section('title', 'Backup & Restore')
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Backup & Restore</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Backup & Restore</h1>
            <p class="text-slate-500 text-sm">Manage database backups and restores.</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-primary mb-2">Run Backup</h2>
            <p class="text-slate-500 text-sm mb-6">Create a snapshot of the current database and download it as a <code class="bg-slate-100 px-1 rounded text-xs">.sql</code> file.</p>
            <form action="{{ route('admin.backup.run') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full px-6 py-2.5 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition flex items-center justify-center gap-2">
                    @include('layouts.nav.icon', ['name' => 'database'])
                    Run Backup Now
                </button>
            </form>
        </div>

        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-primary mb-2">Restore from Backup</h2>
            <p class="text-slate-500 text-sm mb-6">Upload a <code class="bg-slate-100 px-1 rounded text-xs">.sql</code> file to restore the database. This action is irreversible.</p>
            <form action="{{ route('admin.backup.restore') }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to restore? This will overwrite current data.')">
                @csrf
                <div class="mb-4">
                    <label for="backup_file" class="block text-sm font-medium text-slate-700 mb-1">Select .sql file</label>
                    <input type="file" name="backup_file" id="backup_file" accept=".sql" required
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary file:mr-3 file:py-1.5 file:px-3 file:rounded-btn file:border-0 file:text-sm file:font-medium file:bg-secondary/10 file:text-secondary hover:file:bg-secondary/20">
                    @error('backup_file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full px-6 py-2.5 rounded-btn bg-red-50 border border-red-200 text-red-600 text-sm font-medium hover:bg-red-100 transition flex items-center justify-center gap-2">
                    @include('layouts.nav.icon', ['name' => 'document'])
                    Restore Database
                </button>
            </form>
        </div>
    </div>
@endsection