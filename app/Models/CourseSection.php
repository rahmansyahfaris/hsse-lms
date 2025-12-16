<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseSection extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'type',
        'content',
        'original_filename',
        'order',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
