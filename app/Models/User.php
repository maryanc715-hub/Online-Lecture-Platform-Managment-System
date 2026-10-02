<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'role_id', 'name', 'email', 'phone', 'student_id',
        'avatar', 'password', 'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string $name): bool
    {
        return $this->role && $this->role->name === $name;
    }

    public function isApproved(): bool
    {
        return $this->status === 'active';
    }

    public function hasPermission(string $permission): bool
    {
        return $this->role && $this->role->permissions->contains('name', $permission);
    }

    // Instructor relationships
    public function coursesTaught()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    // Student relationships
    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class, 'student_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_enrollments', 'student_id', 'course_id');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'student_id');
    }

    public function progress()
    {
        return $this->hasMany(StudentProgress::class, 'student_id');
    }

    public function lectureCompletions()
    {
        return $this->hasMany(LectureCompletion::class, 'student_id');
    }

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class, 'student_id');
    }

    public function assignedTickets()
    {
        return $this->hasMany(SupportTicket::class, 'assigned_to');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function liveSessionsConducted()
    {
        return $this->hasMany(LiveSession::class, 'instructor_id');
    }
}
