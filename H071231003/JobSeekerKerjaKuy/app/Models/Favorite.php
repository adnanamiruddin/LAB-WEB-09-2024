<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }
}
