<?php

namespace GearHub\Tactician\Contracts\Bus;

use ArrayAccess;
use Closure;

interface Dispatcher
{
    /**
     * Dispatch a command to its respective handler.
     *
     * @param  mixed $command
     *
     * @return mixed
     */
    public function dispatch($command);

    /**
     * Marshal a command and dispatch it to its respective handler.
     *
     * @param  mixed       $command
     * @param  ArrayAccess $source
     * @param  array       $extras
     *
     * @return mixed
     */
    public function dispatchFrom($command, ArrayAccess $source, array $extras = []);

    /**
     * Marshal a command and dispatch it to its respective handler.
     *
     * @param  mixed  $command
     * @param  array  $array
     *
     * @return mixed
     */
    public function dispatchFromArray($command, array $array);
}
