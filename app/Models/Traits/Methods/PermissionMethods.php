<?php

namespace App\Models\Traits\Methods;

/**
 * Trait PermissionMethods.
 */
trait PermissionMethods
{
    /**
     * defaultPermissions function.
     *
     * @static
     *
     * @return void
     */
    public static function defaultPermissions()
    {

        return [

            'backend.index',

            'backend.users.index',
            'backend.users.edit',
            'backend.users.show',
            'backend.users.update',
            'backend.users.create',
            'backend.users.store',
            'backend.users.destroy',
            'backend.users.view.deactive',
            'backend.users.view.deleted',

            'backend.roles.index',
            'backend.roles.edit',
            'backend.roles.show',
            'backend.roles.update',
            'backend.roles.create',
            'backend.roles.store',
            'backend.roles.destroy',

            'backend.permissions.index',
            'backend.permissions.edit',
            'backend.permissions.show',
            'backend.permissions.update',
            'backend.permissions.create',
            'backend.permissions.store',
            'backend.permissions.destroy',

        ];
    }

    /**
     * @return string
     */
    public function getNameLabelAttribute()
    {
        return ucwords(str_replace('.', ' ', $this->name));
    }
}
