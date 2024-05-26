<?php

namespace App\Tests\Service;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\Entity\Product;
use App\Domain\Order\Service\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    private $entityManager;
    private $pricingService;
    private $orderService;
    private $productRepository;
    private $orderRepository;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->pricingService = $this->createMock(\App\Domain\Order\Service\PricingService::class);
        $this->productRepository = $this->createMock(EntityRepository::class);
        $this->orderRepository = $this->createMock(EntityRepository::class);

        $this->entityManager->method('getRepository')
            ->willReturnMap([
                [Product::class, $this->productRepository],
                [Order::class, $this->orderRepository]
            ]);

        $this->orderService = new OrderService($this->entityManager, $this->pricingService);
    }

    public function testCreateOrder()
    {
        $product = new Product();
        $product->setPrice(10000); // 100.00 PLN w groszach

        $this->productRepository->method('find')->willReturn($product);
        $this->entityManager->expects($this->exactly(2))->method('persist');
        $this->entityManager->expects($this->once())->method('flush');

        $this->pricingService->expects($this->once())->method('calculate')
            ->willReturnCallback(function(Order $order) {
                $totalPrice = 0;
                $totalVat = 0;
                $totalAmount = 0;
                foreach ($order->getOrderItems() as $item) {
                    $totalPrice += $item->getPrice() * $item->getQuantity();
                    $totalVat += $item->getVat() * $item->getQuantity();
                    $totalAmount += $item->getTotal() * $item->getQuantity();
                }
                $order->setTotalPrice($totalPrice);
                $order->setTotalVat($totalVat);
                $order->setTotalAmount($totalAmount);
            });

        $items = [
            ['product_id' => 1, 'quantity' => 2]
        ];

        $order = $this->orderService->createOrder($items);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertCount(1, $order->getOrderItems());
        $this->assertEquals(20000, $order->getTotalPrice());
        $this->assertEquals(4600, $order->getTotalVat());
        $this->assertEquals(24600, $order->getTotalAmount());
    }

    public function testGetOrder()
    {
        $order = new Order();
        $this->orderRepository->method('find')->willReturn($order);

        $result = $this->orderService->getOrder(1);

        $this->assertInstanceOf(Order::class, $result);
    }
}
