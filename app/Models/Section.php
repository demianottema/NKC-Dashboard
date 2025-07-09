<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function sectionPages(): HasMany
    {
        return $this->hasMany(SectionPage::class);
    }
}