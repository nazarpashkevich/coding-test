<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 * @property \Carbon\CarbonInterface $completed_at
 * @property \App\Models\Phase $phase
 */
class Task extends Model
{
    use HasFactory;

    protected $casts = ['completed_at' => 'datetime'];

    protected $fillable = [
        'name',
        'completed_at',
        'phase_id',
        'user_id',
    ];

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function phase(): BelongsTo
    {
        return $this->belongsTo(Phase::class);
    }
}
