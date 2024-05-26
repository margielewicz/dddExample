<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Entity\Order;

interface PricingCollectorInterface
{
    public function collect(Order $order);
}
