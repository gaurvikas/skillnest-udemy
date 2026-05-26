<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public const STATUS_OPTIONS = [
        'pending' => 'Pending',
        'read' => 'Read',
        'replied' => 'Replied',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'subject',
        'message',
        'ip_address',
    ];
}
