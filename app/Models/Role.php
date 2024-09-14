<?php

namespace App\Models;

use App\Models\Traits\Attributes\RoleAttributes;
use App\Models\Traits\Methods\RoleMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Table: roles
*
* === Columns ===
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
*/
class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory, RoleAttributes, RoleMethods;
}
