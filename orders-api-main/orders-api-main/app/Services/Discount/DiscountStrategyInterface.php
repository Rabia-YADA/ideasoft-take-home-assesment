<?php

namespace App\Services\Discount;

use App\Models\Order;

interface DiscountStrategyInterface
{
    /**
     * @return array [
     *     'discountReason' => string,
     *     'discountAmount' => float,
     *     'subtotal' => float
     * ]
     */
    public function apply(Order $order, float $currentSubtotal): array;
}
