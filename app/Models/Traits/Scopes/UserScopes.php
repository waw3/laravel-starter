<?php

namespace App\Models\Traits\Scopes;

/**
 * Class UserScopes.
 */
trait UserScopes
{
    /**
     * @param  bool  $confirmed
     * @return mixed
     */
    public function scopeConfirmed($query, $confirmed = true)
    {
        return $query->where('confirmed', $confirmed);
    }

    /**
     * @param  bool  $status
     * @return mixed
     */
    public function scopeActive($query, $status = true)
    {
        return $query->where('active', $status);
    }

    /**
     * scopeEmail function.
     *
     * @param  mixed  $query
     * @param  mixed  $type
     * @return void
     */
    public function scopeEmail($query, $type)
    {
        if ($type != null or $type != '') {
            return $query->whereEmail($type);
        }
    }

    /**
     * scopeTrash function.
     *
     * @param  mixed  $query
     * @return void
     */
    public function scopeTrash($query)
    {
        return $query->onlyTrashed();
    }

    /**
     * scopeLastUpdate function.
     *
     * @param  mixed  $query
     * @return void
     */
    public function scopeLastUpdate($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * scopeToday function.
     *
     * @param  mixed  $query
     * @return void
     */
    public function scopeToday($query)
    {
        return $query->where('created_at', '>', Carbon::today())->where('created_at', '<', Carbon::today()->addDay());
    }

    /**
     * scopeWeek function.
     *
     * @param  mixed  $query
     * @return void
     */
    public function scopeWeek($query)
    {
        return $query->where('created_at', '>', Carbon::today()->subWeek())->where('created_at', '<', Carbon::today()->addDay());
    }

    /**
     * scopeMonth function.
     *
     * @param  mixed  $query
     * @return void
     */
    public function scopeMonth($query)
    {
        return $query->where('created_at', '>', Carbon::today()->subMonth())->where('created_at', '<', Carbon::today()->addDay());
    }
}
