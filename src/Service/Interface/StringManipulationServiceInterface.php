<?php

namespace App\Service\Interface;

interface StringManipulationServiceInterface
{
/**
* Remove specified parts from the input string.
*
* @param string $inputString The input string.
* @param array $partsToRemove An array of parts to be removed from the input string.
*
* @return string The modified string after removing specified parts.
*/
public function removePartsFromString(string $inputString, array $partsToRemove): string;
}
