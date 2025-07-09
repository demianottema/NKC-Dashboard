<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SectionPage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts =[
        'content' => 'array',
    ];
    
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}