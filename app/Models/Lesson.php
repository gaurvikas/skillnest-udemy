<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Lesson extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    public const PREVIEW_OPTIONS = [
        1 => 'Yes',
        0 => 'No',
    ];

    protected $fillable = [
        'section_id',
        'title',
        'slug',
        'content',
        'duration',
        'order',
        'is_preview',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('video')
            ->singleFile() // only one video per lesson
            ->acceptsMimeTypes(['video/mp4', 'video/quicktime', 'video/x-msvideo']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->extractVideoFrameAtSecond(1)
            ->queued();
    }

    // -------------------------------------------------------
    // Accessors
    // -------------------------------------------------------

    protected function preview(): Attribute
    {
        return Attribute::make(
            get: fn () => self::PREVIEW_OPTIONS[$this->is_preview] ?? null,
        );
    }

    protected function formattedDuration(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->duration) {
                    return '—';
                }

                $hours = floor($this->duration / 3600);
                $minutes = floor(($this->duration % 3600) / 60);
                $seconds = $this->duration % 60;

                if ($hours > 0) {
                    return "{$hours}h {$minutes}m {$seconds}s";
                }

                if ($minutes > 0) {
                    return "{$minutes}m {$seconds}s";
                }

                return "{$seconds}s";
            }
        );
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function course()
    {
        return $this->hasOneThrough(
            Course::class,   // final model we want
            Section::class,  // intermediate model
            'id',            // foreign key on Section matching Lesson's section_id
            'id',            // foreign key on Course matching Section's course_id
            'section_id',    // local key on Lesson
            'course_id'      // local key on Section
        );
    }
}
