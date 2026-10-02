<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'label' => 'Administrator', 'description' => 'Full system access'],
            ['name' => 'instructor', 'label' => 'Instructor', 'description' => 'Manages courses and grades'],
            ['name' => 'student', 'label' => 'Student', 'description' => 'Enrolled learner'],
            ['name' => 'support_staff', 'label' => 'Support Staff', 'description' => 'Handles support tickets'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }

        $permissions = [
            'users.manage', 'courses.manage', 'categories.manage', 'lectures.manage',
            'assignments.manage', 'assignments.grade', 'tickets.manage', 'tickets.respond',
            'announcements.manage', 'reports.manage', 'settings.manage', 'roles.manage',
            'messages.send', 'progress.view',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission], ['label' => ucwords(str_replace(['.', '_'], ' ', $permission))]);
        }

        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->permissions()->sync(Permission::all()->pluck('id'));

        $instructorRole = Role::where('name', 'instructor')->first();
        $instructorRole->permissions()->sync(Permission::whereIn('name', [
            'lectures.manage', 'assignments.manage', 'assignments.grade',
            'announcements.manage', 'messages.send', 'progress.view',
        ])->pluck('id'));

        $studentRole = Role::where('name', 'student')->first();
        $studentRole->permissions()->sync(Permission::whereIn('name', [
            'messages.send', 'progress.view',
        ])->pluck('id'));

        $supportRole = Role::where('name', 'support_staff')->first();
        $supportRole->permissions()->sync(Permission::whereIn('name', [
            'tickets.manage', 'tickets.respond', 'messages.send',
        ])->pluck('id'));
    }
}
