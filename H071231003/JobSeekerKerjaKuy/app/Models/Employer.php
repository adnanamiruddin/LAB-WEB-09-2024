<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employer extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'employer_id');
    }
}
