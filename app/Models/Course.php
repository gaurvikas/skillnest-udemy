<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Course extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Searchable, SoftDeletes;

    public const LEVEL_OPTIONS = [
        'beginner' => 'Beginner',
        'intermediate' => 'Intermediate',
        'advanced' => 'Advanced',
    ];

    public const STATUS_OPTIONS = [
        'draft' => 'Draft',
        'pending' => 'Pending',
        'published' => 'Published',
        'rejected' => 'Rejected',
    ];

    protected $fillable = [
        'instructor_id',
        'title',
        'slug',
        'description',
        'original_price',
        'price',
        'level',
        'status',
        'duration',
        'published_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function toSearchableArray()
    {
        return [
            'id' => (string) $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => (float) $this->price,
            'level' => $this->level,
            'duration' => (float) $this->duration,
            'reviews_count' => (int) $this->reviews()->count(),
            'category_ids' => $this->categories->pluck('id')->toArray(),
            'average_rating' => (float) $this->reviews()->avg('rating') ?? 0,
            'created_at' => $this->created_at?->timestamp,
        ];
    }

    protected function priceInr(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => isset($attributes['price'])
                ? '$'.number_format($attributes['price'], 0, '.', ',')
                : null
        );
    }

    protected function priceDiscount(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => number_format((($attributes['original_price'] - $attributes['price']) / $attributes['original_price']) * 100, 0).'%'
        );
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Section::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(CourseReview::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
