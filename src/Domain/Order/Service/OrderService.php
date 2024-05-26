<?php

namespace App\Domain\Order\Service;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\Entity\OrderItem;
use App\Domain\Order\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    private EntityManagerInterface $entityManager;
    private PricingService $pricingService;

    public function __construct(EntityManagerInterface $entityManager, PricingService $pricingService)
    {
        $this->entityManager = $entityManager;
        $this->pricingService = $pricingService;
    }

    public function createOrder(array $items): Order
    {
        $order = new Order();
        $order->setCreatedAt(new \DateTime());

        foreach ($items as $itemData) {
            $product = $this->entityManager->getRepository(Product::class)->find($itemData['product_id']);
            if (!$product) {
                throw new \Exception('Product not found');
            }

            $orderItem = new OrderItem();
            $orderItem->setProduct($product);
            $orderItem->setQuantity($itemData['quantity']);
            $orderItem->setPrice($product->getPrice());
            $orderItem->setVat((int)($product->getPrice() * 0.23));
            $orderItem->setTotal($orderItem->getPrice() + $orderItem->getVat());

            $order->addOrderItem($orderItem);
            $this->entityManager->persist($orderItem);
        }

        $this->pricingService->calculate($order);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }

    public function getOrder(int $orderId): ?Order
    {
        return $this->entityManager->getRepository(Order::class)->find($orderId);
    }
}
