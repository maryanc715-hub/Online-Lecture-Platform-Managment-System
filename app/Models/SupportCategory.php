<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportCategory extends Model
{
    protected $fillable = ['name'];

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class, 'category_id');
    }
}
