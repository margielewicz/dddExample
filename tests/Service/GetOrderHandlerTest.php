<?php

namespace App\Tests\Handler;

use App\Application\Query\GetOrderQuery;
use App\Domain\Order\Service\OrderService;
use PHPUnit\Framework\TestCase;

class GetOrderHandlerTest extends TestCase
{
    private $orderService;
    private $getOrderHandler;

    protected function setUp(): void
    {
        $this->orderService = $this->createMock(OrderService::class);
        $this->getOrderHandler = new \App\Application\Query\GetOrderHandler($this->orderService);
    }

    public function testHandle()
    {
        $order = new \App\Domain\Order\Entity\Order();
        $this->orderService->expects($this->once())->method('getOrder')->with(1)->willReturn($order);

        $query = new GetOrderQuery(1);
        $result = $this->getOrderHandler->handle($query);

        $this->assertSame($order, $result);
    }
}
