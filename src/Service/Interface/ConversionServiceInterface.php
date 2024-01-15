<?php

namespace App\Service\Interface;

use InvalidArgumentException;

interface ConversionServiceInterface
{
    /**
     * Handles mixed value conversion to string.
     *
     * @param mixed $value
     * @return string
     * @throws InvalidArgumentException If the value type is not supported.
     */
    public function handleMixedToString(mixed $value): string;

}
