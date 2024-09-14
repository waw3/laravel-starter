<?php

namespace App\Models\Traits\Methods;

use Carbon\Carbon;

/**
 * Trait UserMethods.
 */
trait UserMethods
{
    /**
     * parseDate function.
     *
     * @param  mixed  $date
     * @return void
     */
    public function parseDate($date)
    {
        return ($date != null) ? Carbon::parse($date)->format(config('app.date_time_format')) : null;
    }

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * normalizeEmail function.
     *
     * @static
     *
     * @param  mixed  $value
     * @return void
     */
    public static function normalizeEmail($value)
    {
        return trim(strtolower($value));
    }

    /**
     * findByEmail function.
     *
     * @static
     *
     * @param  mixed  $email
     * @return void
     */
    public static function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    /**
     * hasAbility
     *
     * @param  string $ability
     *
     * @return void
     */
    public function hasAbility($ability)
    {
        // dd($this->getAllPermissions());
        foreach ($this->getAllPermissions() as $permission) {
            if ($permission->name == $ability) {
                return true;
            }
        }

        return false;
    }
}
