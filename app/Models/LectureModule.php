<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LectureModule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'course_id', 'title', 'description', 'sort_order',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lectureMaterials()
    {
        return $this->hasMany(LectureMaterial::class, 'module_id')
            ->orderBy('sort_order')
            ->orderBy('created_at');
    }
}
