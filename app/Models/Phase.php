<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property boolean $is_completable
 * @property \Illuminate\Support\Collection<\App\Models\Task> $tasks
 */
class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
