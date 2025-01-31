<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'post_limit',
        'social_account_limit',
        'smart_post_enabled',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}