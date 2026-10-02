<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'instructor_id', 'title', 'slug', 'description',
        'duration', 'thumbnail', 'status', 'start_date', 'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function getThumbnailUrlAttribute(): ?string
    {
        if (! $this->thumbnail) {
            return null;
        }

        return Storage::disk('public')->url($this->thumbnail);
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_enrollments', 'course_id', 'student_id');
    }

    public function lectureMaterials()
    {
        return $this->hasMany(LectureMaterial::class);
    }

    public function lectureModules()
    {
        return $this->hasMany(LectureModule::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function progress()
    {
        return $this->hasMany(StudentProgress::class);
    }

    public function liveSessions()
    {
        return $this->hasMany(LiveSession::class)->orderByDesc('scheduled_at');
    }
}
