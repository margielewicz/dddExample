<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Entity\Order;

class TotalAmountCollector implements PricingCollectorInterface
{
    public function collect(Order $order)
    {
        $totalAmount = 0;
        foreach ($order->getOrderItems() as $item) {
            $totalAmount += $item->getTotal() * $item->getQuantity();
        }
        $order->setTotalAmount($totalAmount);
    }
}
