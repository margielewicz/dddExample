<?php

namespace App\Application\Query;

class GetOrderQuery
{
    public int $orderId;

    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }
}
