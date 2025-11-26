<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'duration_hours'];

    public function sections()
    {
        return $this->hasMany(CourseSection::class)->orderBy('order');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_enrollments')
                    ->withPivot('status', 'enrolled_at')
                    ->withTimestamps();
    }
}


