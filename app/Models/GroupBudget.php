<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupBudget extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'year' => 'integer',
        'total_budget' => 'decimal:2',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(GroupBudgetExpense::class);
    }
}