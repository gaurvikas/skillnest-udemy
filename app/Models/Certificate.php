<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Certificate extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'course_id',
        'certificate_number',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($certificate) {

            if (empty($certificate->certificate_number)) {
                $certificate->certificate_number = self::generateUniqueNumber();
            }
        });
    }

    public static function generateUniqueNumber()
    {
        do {
            $number = 'CERT-'.date('Y').'-'.strtoupper(Str::random(8));
        } while (self::where('certificate_number', $number)->exists());

        return $number;
    }
}
