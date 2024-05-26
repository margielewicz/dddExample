<?php

namespace App\Application\Command;

class CreateOrderCommand
{
    public array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }
}
