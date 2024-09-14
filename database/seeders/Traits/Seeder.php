<?php

namespace Database\Seeders\Traits;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Seeder as IlluminateSeeder;

/**
 * Abstract Seeder class.
 *
 * @extends IlluminateSeeder
 */
abstract class Seeder extends IlluminateSeeder
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Seeder collection.
     *
     * @var array
     */
    protected $seeds = [];

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Run the database seeds.
     */
    public function run()
    {
        Eloquent::unguard();

        foreach ($this->seeds as $seed) {
            $this->call($seed);
        }

        Eloquent::reguard();
    }
}
