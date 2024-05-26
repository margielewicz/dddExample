<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Entity\Order;

class VatCollector implements PricingCollectorInterface
{
    public function collect(Order $order)
    {
        $totalVat = 0;
        foreach ($order->getOrderItems() as $item) {
            $totalVat += $item->getVat() * $item->getQuantity();
        }
        $order->setTotalVat($totalVat);
    }
}
