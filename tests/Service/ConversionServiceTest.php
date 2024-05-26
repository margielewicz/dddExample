<?php

namespace App\Tests\Service;

use App\Domain\Order\Service\ConversionService;
use PHPUnit\Framework\TestCase;

class ConversionServiceTest extends TestCase
{
    private ConversionService $conversionService;

    protected function setUp(): void
    {
        $this->conversionService = new \App\Domain\Order\Service\ConversionService();
    }

    public function testConvertToDecimal()
    {
        $this->assertEquals(123.45, $this->conversionService->convertToDecimal(12345));
        $this->assertEquals(0.99, $this->conversionService->convertToDecimal(99));
        $this->assertEquals(0.0, $this->conversionService->convertToDecimal(0));
        $this->assertEquals(-123.45, $this->conversionService->convertToDecimal(-12345));
    }
}
