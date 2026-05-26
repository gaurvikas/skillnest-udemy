<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    protected $table = 'lesson_progress';

    public const IS_COMPLETE = [
        1 => 'Yes',
        0 => 'No',
    ];

    protected $fillable = [
        'user_id',
        'lesson_id',
        'watched_seconds',
        'is_completed',
        'completed_at',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function isCompleted(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => self::IS_COMPLETE[$value] ?? null,
        );
    }
}
