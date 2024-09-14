<?php

namespace App\Models\Traits\Relationships;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class UserRelationships.
 */
trait UserRelationships
{
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }
}
