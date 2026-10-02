<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['generated_by', 'type', 'title', 'filters', 'file_path', 'format'];

    protected $casts = ['filters' => 'array'];

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
