<?php

namespace App\Models\Traits\Relationships;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BlogRelationships.
 */
trait BlogRelationships
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
