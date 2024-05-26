<?php

namespace App\Tests\Handler;

use App\Application\Command\CreateOrderCommand;
use App\Application\Command\CreateOrderHandler;
use App\Domain\Order\Entity\Order;
use App\Domain\Order\Service\OrderService;
use PHPUnit\Framework\TestCase;

class CreateOrderHandlerTest extends TestCase
{
    private $orderService;
    private $createOrderHandler;

    protected function setUp(): void
    {
        $this->orderService = $this->createMock(OrderService::class);
        $this->createOrderHandler = new CreateOrderHandler($this->orderService);
    }

    public function testHandle()
    {
        $items = [
            ['product_id' => 1, 'quantity' => 2]
        ];

        $order = new Order();
        $this->orderService->expects($this->once())->method('createOrder')->with($items)->willReturn($order);

        $command = new CreateOrderCommand($items);
        $result = $this->createOrderHandler->handle($command);

        $this->assertSame($order, $result);
    }
}
