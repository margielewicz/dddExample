<?php

namespace App\Tests\Service;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\Entity\OrderItem;
use App\Domain\Order\Entity\Product;
use PHPUnit\Framework\TestCase;

class TotalAmountCollectorTest extends TestCase
{
    public function testCollect()
    {
        $order = new Order();
        $product = new Product();
        $product->setPrice(100.00);

        $orderItem = new OrderItem();
        $orderItem->setProduct($product);
        $orderItem->setQuantity(2);
        $orderItem->setTotal(123.00);

        $order->addOrderItem($orderItem);

        $collector = new \App\Domain\Order\Service\TotalAmountCollector();
        $collector->collect($order);

        $this->assertEquals(246.00, $order->getTotalAmount());
    }
}
