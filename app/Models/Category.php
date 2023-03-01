<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;


class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'name',
        'status'
    ];

    public function jobs() {
        return $this->belongsToMany(Job::class);
    }
}
