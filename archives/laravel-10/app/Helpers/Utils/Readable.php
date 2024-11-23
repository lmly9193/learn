<?php

namespace App\Helpers\Utils;

class Readable
{
    public function __construct(
        protected mixed $value,
    ) {
    }

    /**
     * Convert the byte into a human-readable size.
     */
    public function bytes(int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB'];
        [$bytes, $precision] = [max($this->value, 0), max($precision, 0)];
        $exponent = min(floor(log($bytes, 1024)), 6);
        return round($bytes / pow(1024, $exponent), $precision) . $units[$exponent];
    }
}
