<?php

namespace App\Models\Traits\Methods;

/**
 * Trait RoleMethods.
 */
trait RoleMethods
{
    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->name === 'admin';
    }

    /**
     * Set role's permissions.
     *
     * @return void
     */
    public function setPermissionsAttribute(array $permissions)
    {
        $this->attributes['permissions'] = Permission::prepare($permissions);
    }

    /**
     * list function. Get a list of all roles.
     *
     * @static
     *
     * @return array
     */
    public static function list()
    {
        return static::select('name', 'id')->get()->pluck('name', 'id');
    }

    /**
     * defaultRoles function.
     *
     * @static
     */
    public static function defaultRoles(): array
    {
        return [
            'admin',
            'user',
        ];
    }
}
