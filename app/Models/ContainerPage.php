<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContainerPage extends Model
{
    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class);
    }
}
