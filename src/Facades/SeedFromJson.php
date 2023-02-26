<?php

namespace SergeyBruhin\SeedFromJson\Facades;

use Illuminate\Support\Facades\Facade;

class SeedFromJson extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'seed-from-json';
    }
}
