<?php

namespace Laservici\Authsocial\Contracts;

interface Factory
{
    /**
     * Get an OAuth provider implementation.
     *
     * @param  string  $driver
     * @return \Laservici\Authsocial\Contracts\Provider
     */
    public function driver($driver = null);
}
