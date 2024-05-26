<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Entity\Order;

class PricingService
{
    private $collectors = [];

    public function addCollector(PricingCollectorInterface $collector)
    {
        $this->collectors[] = $collector;
    }

    public function calculate(Order $order)
    {
        foreach ($this->collectors as $collector) {
            $collector->collect($order);
        }
    }
}
