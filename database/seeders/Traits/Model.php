<?php

namespace Database\Seeders\Traits;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Modules\Support\Traits\PrefixedModel;

/**
 * Abstract Model class.
 *
 * @extends Eloquent
 */
abstract class Model extends Eloquent
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use PrefixedModel;
}
