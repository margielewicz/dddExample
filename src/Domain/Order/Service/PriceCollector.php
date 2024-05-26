<?php
namespace App\Domain\Order\Service;

use App\Domain\Order\Entity\Order;

class PriceCollector implements PricingCollectorInterface
{
    public function collect(Order $order)
    {
        $totalPrice = 0;
        foreach ($order->getOrderItems() as $item) {
            $totalPrice += $item->getPrice() * $item->getQuantity();
        }
        $order->setTotalPrice($totalPrice);
    }
}
