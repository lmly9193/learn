<?php

namespace App\Mixins;

final class StrMixin
{
    /**
     * Replace backslash with slash.
     */
    public function slash()
    {
        return fn (string $str): string => str_replace('\\', '/', $str);
    }
}
