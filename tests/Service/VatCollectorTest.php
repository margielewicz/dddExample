<?php

namespace App\Tests\Service;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\Entity\OrderItem;
use App\Domain\Order\Entity\Product;
use App\Domain\Order\Service\VatCollector;
use PHPUnit\Framework\TestCase;

class VatCollectorTest extends TestCase
{
    public function testCollect()
    {
        $order = new Order();
        $product = new Product();
        $product->setPrice(100.00);

        $orderItem = new OrderItem();
        $orderItem->setProduct($product);
        $orderItem->setQuantity(2);
        $orderItem->setVat(23.00);

        $order->addOrderItem($orderItem);

        $collector = new VatCollector();
        $collector->collect($order);

        $this->assertEquals(46.00, $order->getTotalVat());
    }
}
