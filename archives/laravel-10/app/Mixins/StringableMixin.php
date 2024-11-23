<?php

namespace App\Mixins;

use Illuminate\Support\Stringable;

final class StringableMixin
{
    /**
     * Replace backslash with slash.
     */
    public function slash()
    {
        return function (): Stringable {
            /** @var Stringable $this */
            $this->value = str()->slash($this->value);
            return $this;
        };
    }
}
