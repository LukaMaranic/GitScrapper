<?php

namespace App\Service\Implementation;

use App\Service\Interface\StringManipulationServiceInterface;

class StringManipulationService implements StringManipulationServiceInterface
{
    public function removePartsFromString(string $inputString, array $partsToRemove): string
    {
        foreach ($partsToRemove as $part) {
            $inputString = str_replace($part, '', $inputString);
        }

        return $inputString;
    }
}
