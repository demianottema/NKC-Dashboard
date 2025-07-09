<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupBudgetExpense extends Model
{
    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(GroupBudget::class, 'group_budget_id');
    }
}