<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use SoftDeletes;

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    protected $fillable = [
        'name',
        'url',
        'image',
    ];
}
