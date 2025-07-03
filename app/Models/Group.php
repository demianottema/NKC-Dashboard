<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GalleryJsonMedia\JsonMedia\Contracts\HasMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use GalleryJsonMedia\JsonMedia\Concerns\InteractWithMedia;

class Group extends Model implements HasMedia
{
    use InteractWithMedia;
 
    protected $guarded = [];
    protected $casts =[
        'files' => 'array',
    ];

    public function budgets(): HasMany
    {
        return $this->hasMany(GroupBudget::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    protected function getFieldsToDeleteMedia(): array {
        return ['files'];
    }
}
