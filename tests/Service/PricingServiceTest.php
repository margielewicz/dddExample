<?php

namespace App\Tests\Service;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\Entity\OrderItem;
use App\Domain\Order\Entity\Product;
use App\Domain\Order\Service\PriceCollector;
use App\Domain\Order\Service\TotalAmountCollector;
use App\Domain\Order\Service\VatCollector;
use PHPUnit\Framework\TestCase;

class PricingServiceTest extends TestCase
{
    public function testCalculate()
    {
        $order = new Order();
        $product = new Product();
        $product->setPrice(100.00);

        $orderItem = new OrderItem();
        $orderItem->setProduct($product);
        $orderItem->setQuantity(2);
        $orderItem->setPrice(100.00);
        $orderItem->setVat(23.00);
        $orderItem->setTotal(123.00);

        $order->addOrderItem($orderItem);

        $pricingService = new \App\Domain\Order\Service\PricingService();
        $pricingService->addCollector(new PriceCollector());
        $pricingService->addCollector(new VatCollector());
        $pricingService->addCollector(new TotalAmountCollector());

        $pricingService->calculate($order);

        $this->assertEquals(200.00, $order->getTotalPrice());
        $this->assertEquals(46.00, $order->getTotalVat());
        $this->assertEquals(246.00, $order->getTotalAmount());
    }
}
