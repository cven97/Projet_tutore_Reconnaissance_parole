<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Appareil extends Model
{
    use HasFactory;

    public function piece(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_appareils');
    }
}
