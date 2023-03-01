<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Type;
use App\Models\Salary;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'title',
        'category_id',
        'type_id',
        'salary_id',
        'description',
        'skills',
        'publisher_id',
        'status'
    ];


    public function publisher() {
        return $this->belongsTo(User::class, 'publisher_id');
    }

    public function type() {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function salary() {
        return $this->belongsTo(Salary::class, 'salary_id');
    }

    public function category() {
        return $this->belongsToMany(Category::class);
    }
}
