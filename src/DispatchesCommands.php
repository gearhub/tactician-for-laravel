<?php

namespace GearHub\Tactician;

use ArrayAccess;

trait DispatchesCommands
{
    /**
     * Dispatch a command to its respective handler.
     *
     * @param  mixed $command
     *
     * @return mixed
     */
    protected function dispatchCommand($command)
    {
        return app('tactician.dispatcher')->dispatch($command);
    }

    /**
     * Marshal a command and dispatch it to its respective handler.
     *
     * @param  mixed       $command
     * @param  ArrayAccess $source
     * @param  array       $extras
     *
     * @return mixed
     */
    protected function dispatchCommandFrom($command, ArrayAccess $source, array $extras = [])
    {
        return app('tactician.dispatcher')->dispatchFrom($command, $source, $extras);
    }

    /**
     * Marshal a command and dispatch it to its respective handler.
     *
     * @param  mixed  $command
     * @param  array  $array
     *
     * @return mixed
     */
    protected function dispatchCommandFromArray($command, array $array)
    {
        return app('tactician.dispatcher')->dispatchFromArray($command, $array);
    }
}
