<?php

if (! function_exists('readable')) {
    /**
     * Create a new instance of the Readable Helper.
     */
    function readable(mixed $value): \App\Helpers\Utils\Readable
    {
        return new \App\Helpers\Utils\Readable($value);
    }
}

if (!function_exists('safely')) {
    /**
     * Try the provided operation, and if it fails, return a default value.
     */
    function safely(callable $callback, mixed $default = null): mixed {
        try {
            return $callback();
        } catch (\Throwable $th) {
            logger()->warning('Throw: ' . $th->getMessage());
        }
        return $default;
    }
}
