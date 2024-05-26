<?php

namespace App\Domain\Order\Service;


class OrderResponseFormatter
{
    private ConversionService $conversionService;

    public function __construct(ConversionService $conversionService)
    {
        $this->conversionService = $conversionService;
    }

    public function format($order): array
    {
        return [
            'id' => $order->getId(),
            'created_at' => $order->getCreatedAt(),
            'total_price' => $this->conversionService->convertToDecimal($order->getTotalPrice()),
            'total_vat' => $this->conversionService->convertToDecimal($order->getTotalVat()),
            'total_amount' => $this->conversionService->convertToDecimal($order->getTotalAmount())
        ];
    }
}
