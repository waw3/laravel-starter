<?php

namespace App\Models;

use App\Models\Traits\Relationships\BlogRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Table: blogs
*
* === Columns ===
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $photo
 * @property string|null $video
 * @property string|null $content
 * @property string $status
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
*
* === Relationships ===
 * @property-read \App\Models\User|null $user
*/
class Blog extends Model
{
    use BlogRelationships,
        HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $fillable = [
        'title',
        'slug',
        'photo',
        'video',
        'content',
        'status',
        'user_id',
    ];
}
