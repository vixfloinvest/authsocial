<?php

namespace Laservici\Authsocial\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Laservici\Authsocial\AuthsocialManager
 */
class Laservici extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Laservici\Authsocial\Contracts\Factory';
    }
}
