<?php

namespace App\Services\Discount\Strategies;

use App\Models\Order;
use App\Services\Discount\DiscountStrategyInterface;

class CategoryQuantityDiscount implements DiscountStrategyInterface
{
    public function __construct(
        private int $categoryId,
        private int $buyQuantity,
        private int $freeQuantity
    ) {}

    public function apply(Order $order, float $currentSubtotal): array
    {
        $discountAmount = 0;

        foreach ($order->items as $item) {
            if ($item->product->category_id === $this->categoryId) {
                $applicableTimes = floor($item->quantity / $this->buyQuantity);
                $discountAmount += $applicableTimes * $this->freeQuantity * $item->unit_price;
            }
        }

        if ($discountAmount <= 0) {
            return [];
        }

        return [
            'discountReason' => "BUY_{$this->buyQuantity}_GET_{$this->freeQuantity}_IN_CATEGORY_{$this->categoryId}",
            'discountAmount' => round($discountAmount, 2),
            'subtotal' => round($currentSubtotal - $discountAmount, 2)
        ];
    }
}
