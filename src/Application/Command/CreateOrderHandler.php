<?php

namespace App\Application\Command;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\Service\OrderService;

class CreateOrderHandler
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function handle(CreateOrderCommand $command): Order
    {
        return $this->orderService->createOrder($command->items);
    }
}
