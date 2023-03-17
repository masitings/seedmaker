<?php

namespace Masitings\SeedMaker\Facades;

use Illuminate\Support\Facades\Facade;

class SeedMaker extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'seedmaker';
    }
}
