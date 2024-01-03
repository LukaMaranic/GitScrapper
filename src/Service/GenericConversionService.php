<?php

namespace App\Service;

use InvalidArgumentException;

class GenericConversionService implements ConversionServiceInterface
{
    public function handleMixedToString(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        } elseif (is_numeric($value) || is_bool($value)) {
            return (string)$value;
        } else {
            throw new InvalidArgumentException('Invalid value type: ' . gettype($value));
        }
    }

}
