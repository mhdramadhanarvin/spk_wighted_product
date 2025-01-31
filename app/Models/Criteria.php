<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criteria extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function alternates(): HasMany
    {
        return $this->hasMany(AlternateResult::class);
    }

    public function finals(): HasMany
    {
        return $this->hasMany(FinalResult::class);
    }
}
