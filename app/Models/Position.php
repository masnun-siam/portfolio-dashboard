<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
        'experience_id',
    ];

    public function experience(): BelongsTo
    {
        return $this->belongsTo(Experience::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    protected function casts(): array
    {
        return [
            'start' => 'date',
            'end' => 'date',
        ];
    }
}
