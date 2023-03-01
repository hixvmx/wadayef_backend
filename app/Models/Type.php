<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;

class Type extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'token',
        'name',
        'status'
    ];

    public function jobs() {
        return $this->hasMany(Job::class, 'type_id');
    }
}
