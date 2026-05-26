<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public const STATUS_OPTIONS = [
        1 => 'Yes',
        0 => 'No',
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'icon',
        'parent_id',
    ];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
