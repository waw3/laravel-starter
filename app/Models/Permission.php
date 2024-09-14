<?php

namespace App\Models;

use App\Models\Traits\Methods\PermissionMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory, PermissionMethods;
}
