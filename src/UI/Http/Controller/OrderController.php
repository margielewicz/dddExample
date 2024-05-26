<?php

namespace App\UI\Http\Controller;

use App\Application\Command\CreateOrderCommand;
use App\Application\Command\CreateOrderHandler;
use App\Application\Query\GetOrderHandler;
use App\Application\Query\GetOrderQuery;
use App\Domain\Order\Service\OrderResponseFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private CreateOrderHandler $createOrderHandler;
    private GetOrderHandler $getOrderHandler;
    private OrderResponseFormatter $orderResponseFormatter;

    public function __construct(CreateOrderHandler $createOrderHandler, GetOrderHandler $getOrderHandler, OrderResponseFormatter $orderResponseFormatter)
    {
        $this->createOrderHandler = $createOrderHandler;
        $this->getOrderHandler = $getOrderHandler;
        $this->orderResponseFormatter = $orderResponseFormatter;
    }

    #[Route('/order', name: 'create_order', methods: ['POST'])]
    public function createOrder(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['items']) || !is_array($data['items'])) {
            return new JsonResponse(['error' => 'Invalid input'], 400);
        }

        $command = new CreateOrderCommand($data['items']);

        try {
            $order = $this->createOrderHandler->handle($command);
            return $this->json($this->orderResponseFormatter->format($order), 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/order/{id}', name: 'get_order', methods: ['GET'])]
    public function getOrder(int $id): JsonResponse
    {
        $query = new GetOrderQuery($id);
        $order = $this->getOrderHandler->handle($query);

        if (!$order) {
            return new JsonResponse(['error' => 'Order not found'], 404);
        }

        return $this->json($this->orderResponseFormatter->format($order));
    }
}
