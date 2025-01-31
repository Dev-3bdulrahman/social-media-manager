<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScheduledPost extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'scheduled_at',
        'is_smart_post',
        'logo_path',
        'platforms',
        'status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'platforms' => 'array',
        'is_smart_post' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(PostMedia::class);
    }
}