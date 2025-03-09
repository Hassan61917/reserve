<?php

namespace App\Listeners;

use App\Events\OrderWasPaid;

class RunOrderPaidCallback
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderWasPaid $event): void
    {
        $order = $event->order;
        $item = $order->item;
        $class = $this->getCallbackClass($item->type);
        if (method_exists($class, "order")) {
            $class->order($item);
        }
    }


    private function getCallbackClass(?string $type): string
    {
        return match ($type) {
            default => ""
        };
    }
}
