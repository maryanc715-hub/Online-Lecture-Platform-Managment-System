<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LectureMaterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id', 'module_id', 'instructor_id', 'title', 'description',
        'notes', 'type', 'file_path', 'video_url', 'category', 'visibility', 'sort_order',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function module()
    {
        return $this->belongsTo(LectureModule::class);
    }

    public function completions()
    {
        return $this->hasMany(LectureCompletion::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function videoEmbedUrl(): ?string
    {
        if (! $this->video_url) {
            return null;
        }

        $url = trim($this->video_url);

        if (preg_match('/(?:youtube\.com\/(?:watch\?(?:[^&]+&)*v=|embed\/|shorts\/|live\/)|youtu\.be\/)([\w-]{6,})/i', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        if (preg_match('/(?:vimeo\.com\/|player\.vimeo\.com\/video\/)(\d+)/i', $url, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1];
        }

        return null;
    }

    public function videoFileUrl(): ?string
    {
        if (! $this->video_url) {
            return null;
        }

        $url = trim($this->video_url);

        if (preg_match('/\.(mp4|webm|ogv|ogg|mov|m4v)(\?.*)?$/i', $url)) {
            return $url;
        }

        return null;
    }
}
