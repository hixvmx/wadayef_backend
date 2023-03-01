<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;

class Salary extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'token',
        'name',
        'status'
    ];

    public function job() {
        return $this->hasMany(Job::class, 'salary_id');
    }
}
