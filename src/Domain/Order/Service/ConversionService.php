<?php

namespace App\Domain\Order\Service;

class ConversionService
{
    public function convertToDecimal(int $value): float
    {
        return $value / 100;
    }
}
