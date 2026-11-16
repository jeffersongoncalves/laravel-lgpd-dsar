<?php

namespace JeffersonGoncalves\LgpdDsar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JeffersonGoncalves\LgpdDsar\LgpdDsar
 */
class LgpdDsar extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-lgpd-dsar';
    }
}
