<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Container extends Model
{
    protected $guarded = [];
    
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }
}
