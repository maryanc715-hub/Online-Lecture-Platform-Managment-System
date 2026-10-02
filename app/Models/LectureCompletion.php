<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LectureCompletion extends Model
{
    protected $fillable = [
        'student_id', 'lecture_material_id', 'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function lectureMaterial()
    {
        return $this->belongsTo(LectureMaterial::class);
    }
}
