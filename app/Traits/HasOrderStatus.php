<?php

namespace App\Traits;

use App\Enums\OrderStatus;

trait HasOrderStatus
{
    public function setStatus(OrderStatus $status): OrderStatus
    {
        $this->status = $status;

        return $this->getStatus();
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function isDelivered(): bool
    {
        return $this->getStatus() === OrderStatus::Delivered;
    }

    public function isSent(): bool
    {
        return $this->getStatus() === OrderStatus::Sent;
    }

    public function isAccepted(): bool
    {
        return $this->getStatus() === OrderStatus::Accepted;
    }

    public function isProcessing(): bool
    {
        return $this->getStatus() === OrderStatus::Processing;
    }
}
