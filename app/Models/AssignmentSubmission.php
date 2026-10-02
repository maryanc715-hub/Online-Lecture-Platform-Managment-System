<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $fillable = [
        'assignment_id', 'student_id', 'file_path',
        'submission_note', 'submitted_at', 'status',
    ];

    protected $casts = ['submitted_at' => 'datetime'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function grade()
    {
        return $this->hasOne(Grade::class, 'submission_id');
    }
}
