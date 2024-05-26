<?php

namespace App\Tests\Service;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\Entity\OrderItem;
use App\Domain\Order\Entity\Product;
use App\Domain\Order\Service\PriceCollector;
use PHPUnit\Framework\TestCase;

class PriceCollectorTest extends TestCase
{
    public function testCollect()
    {
        $order = new Order();
        $product = new Product();
        $product->setPrice(100.00);

        $orderItem = new OrderItem();
        $orderItem->setProduct($product);
        $orderItem->setQuantity(2);
        $orderItem->setPrice(100.00);

        $order->addOrderItem($orderItem);

        $collector = new PriceCollector();
        $collector->collect($order);

        $this->assertEquals(200.00, $order->getTotalPrice());
    }
}
