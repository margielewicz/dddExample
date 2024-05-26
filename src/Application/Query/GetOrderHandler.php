<?php

namespace App\Application\Query;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\Service\OrderService;

class GetOrderHandler
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function handle(GetOrderQuery $query): ?Order
    {
        return $this->orderService->getOrder($query->orderId);
    }
}
