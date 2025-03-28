<?php

namespace App\Services\Discount\Strategies;

use App\Models\Order;
use App\Services\Discount\DiscountStrategyInterface;

class CheapestItemDiscount implements DiscountStrategyInterface
{
    public function __construct(
        private int $categoryId,
        private int $minQuantity,
        private float $discountPercentage
    ) {}

    public function apply(Order $order, float $currentSubtotal): array
    {
        $categoryItems = $order->items->filter(
            fn($item) => $item->product->category_id === $this->categoryId
        );

        if ($categoryItems->sum('quantity') < $this->minQuantity) {
            return [];
        }

        $cheapestItem = $categoryItems->sortBy('unit_price')->first();
        $discountAmount = $cheapestItem->unit_price * ($this->discountPercentage / 100) * $cheapestItem->quantity;

        return [
            'discountReason' => "{$this->discountPercentage}%_OFF_CHEAPEST_IN_CATEGORY_{$this->categoryId}",
            'discountAmount' => round($discountAmount, 2),
            'subtotal' => round($currentSubtotal - $discountAmount, 2)
        ];
    }
}
