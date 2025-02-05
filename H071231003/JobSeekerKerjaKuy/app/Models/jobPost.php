<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class jobPost extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    // Dalam model JobPost
    // Model User.php
    // App\Models\Employer.php
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'employer_id', 'id');
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function jobAplications()
    {
        return $this->hasMany(JobAplication::class, 'job_post_id');
    }
}
