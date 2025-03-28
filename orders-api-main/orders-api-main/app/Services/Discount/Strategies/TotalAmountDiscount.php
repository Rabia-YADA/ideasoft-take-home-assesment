<?php

namespace App\Services\Discount\Strategies;

use App\Models\Order;
use App\Services\Discount\DiscountStrategyInterface;

class TotalAmountDiscount implements DiscountStrategyInterface
{
    public function __construct(
        private float $threshold,
        private float $percentage
    ) {}

    public function apply(Order $order, float $currentSubtotal): array
    {
        if ($order->total < $this->threshold) {
            return [];
        }

        $discountAmount = $order->total * ($this->percentage / 100);

        return [
            'discountReason' => "{$this->percentage}%_OVER_{$this->threshold}",
            'discountAmount' => round($discountAmount, 2),
            'subtotal' => round($currentSubtotal - $discountAmount, 2)
        ];
    }
}
