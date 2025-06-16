<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    protected $guarded = [];

    public function budgets(): HasMany
    {
        return $this->hasMany(GroupBudget::class);
    }

    public function containers(): HasMany
    {
        return $this->hasMany(Container::class);
    }
}
